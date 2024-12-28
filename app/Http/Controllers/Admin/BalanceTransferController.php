<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\BalanceTransfer;
use App\Models\AccountTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BalanceTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'transfers' => BalanceTransfer::with('debitTransaction.cashbookAccount', 'creditTransaction.cashbookAccount', 'addUser')->latest()->get(),
        ];
        return view("admin.pages.balanceTransfer.index", $data);
    }

    public function filter(Request $request)
    {
        // Get the start and end date from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // If no date filter is provided, fetch all transactions
        if (!$startDate || !$endDate) {
            $transfers = BalanceTransfer::with('debitTransaction.cashbookAccount', 'creditTransaction.cashbookAccount', 'addUser')
                ->latest()
                ->get();
        } else {
            // Query to filter the transfers based on the date range
            $transfers = BalanceTransfer::with('debitTransaction.cashbookAccount', 'creditTransaction.cashbookAccount', 'addUser')
                ->whereBetween('date', [$startDate, $endDate])
                ->latest()
                ->get();
        }

        // Return a view fragment (HTML table rows)
        return response()->view('admin.pages.balanceTransfer.filter_table', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'accounts'   => Account::latest()->get(['id', 'bank_name', 'account_number']),
        ];
        return view("admin.pages.balanceTransfer.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'transferReason'    => 'nullable|string|max:255',
            'fromAccount'       => 'nullable',
            'toAccount'         => 'nullable|different:fromAccount',
            'amount'            => 'nullable|numeric|min:1|max:' . $request->availableBalance,
            'date'              => 'nullable|date_format:Y-m-d',
            'note'              => 'nullable|string|max:255',
        ]);

        try {
            // get logged in user id
            $userId = Auth::guard('admin')->user()->id;
            $fromAccount = Account::find($request->fromAccount);
            $toAccount = Account::find($request->fromAccount);
            $fromAccountNumber = $fromAccount->account_number;
            $debitReason = "Balance transfer from [$fromAccountNumber]";
            // store debit transaction
            $debitTransaction = AccountTransaction::create([
                'account_id'       => $request->fromAccount,
                'amount'           => $request->amount,
                'reason'           => $debitReason,
                'type'             => 0,
                'transaction_date' => $request->date,
                'created_by'       => $userId,
                'status'           => $request->status,
            ]);

            $toAccountNumber = $toAccount->account_number;;
            $creditReason = "Balance transfer to [$toAccountNumber]";
            // store credit transaction
            $creditTransaction = AccountTransaction::create([
                'account_id'       => $request->toAccount,
                'amount'           => $request->amount,
                'reason'           => $creditReason,
                'type'             => 1,
                'transaction_date' => $request->date,
                'created_by'       => $userId,
                'status'           => $request->status,
            ]);

            // create transfer
            BalanceTransfer::create([
                'reason'     => $request->transferReason,
                'debit_id'   => $debitTransaction->id,
                'credit_id'  => $creditTransaction->id,
                'amount'     => $request->amount,
                'date'       => $request->date,
                'note'       => $request->note,
                'status'     => $request->status,
                'created_by' => $userId,
            ]);

            redirectWithSuccess('Transfer added Successfully');
            return redirect()->route('admin.balance-transfer.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'transfer'   => BalanceTransfer::with('debitTransaction', 'creditTransaction', 'addUser', 'updateUser')->where('id', $id)->first(),
            'accounts'   => Account::latest()->get(['id', 'bank_name', 'account_number']),
        ];
        return view("admin.pages.balanceTransfer.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'transferReason'    => 'nullable|string|max:255',
            'fromAccount'       => 'nullable',
            'toAccount'         => 'nullable|different:fromAccount',
            'amount'            => 'nullable|numeric|min:1|max:' . $request->availableBalance,
            'date'              => 'nullable|date_format:Y-m-d',
            'note'              => 'nullable|string|max:255',
            'status'            => 'nullable|string|in:active,inactive',
        ]);

        try {
            // Get the existing balance transfer
            $transfer = BalanceTransfer::with('debitTransaction', 'creditTransaction', 'addUser', 'updateUser')->where('id', $id)->first();

            // Update debit transaction

            $transfer->debitTransaction->update([
                'account_id'       => $request->fromAccount,
                'amount'           => $request->amount,
                'transaction_date' => $request->date,
                'status'           => $request->status,
                'reason'           => $request->transferReason,
            ]);

            // Update credit transaction

            $transfer->creditTransaction->update([
                'account_id'       => $request->toAccount,
                'amount'           => $request->amount,
                'transaction_date' => $request->date,
                'status'           => $request->status,
                'reason'           => $request->transferReason,
            ]);

            // Update balance transfer record
            $transfer->update([
                'reason'     => $request->transferReason,
                'amount'     => $request->amount,
                'date'       => $request->date,
                'note'       => $request->note,
                'status'     => $request->status,
            ]);

            redirectWithSuccess('Transfer updated successfully');
            return redirect()->route('admin.balance-transfer.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transfer = BalanceTransfer::where('id', $id)->first();

        // check if the transfer can be delete
        $canDelete = true;
        if ($transfer->creditTransaction->cashbookAccount->availableBalance() < $transfer->amount) {
            $canDelete = false;
        }

        if ($canDelete) {
            // delete transfer transactions
            $transfer->debitTransaction->delete();
            $transfer->creditTransaction->delete();
            $transfer->delete();
        }
    }

    public function search(Request $request)
    {
        $term = $request->term;
        $query = BalanceTransfer::with('debitTransaction.cashbookAccount', 'creditTransaction.cashbookAccount', 'user');

        if ($request->startDate && $request->endDate) {
            $query = $query->whereBetween('date', [$request->startDate, $request->endDate]);
        }

        $query->where(function ($query) use ($term) {
            $query->where('reason', 'LIKE', '%' . $term . '%')
                ->orWhere('amount', 'LIKE', '%' . $term . '%')
                ->orWhereHas('debitTransaction', function ($newQuery) use ($term) {
                    $newQuery->whereHas('cashbookAccount', function ($newQuery) use ($term) {
                        $newQuery->where('account_number', 'LIKE', '%' . $term . '%')
                            ->orWhere('bank_name', 'LIKE', '%' . $term . '%');
                    });
                })
                ->orWhereHas('creditTransaction', function ($newQuery) use ($term) {
                    $newQuery->whereHas('cashbookAccount', function ($newQuery) use ($term) {
                        $newQuery->where('account_number', 'LIKE', '%' . $term . '%')
                            ->orWhere('bank_name', 'LIKE', '%' . $term . '%');
                    });
                });
        });

        // return BalanceTransferResource::collection($query->latest()->paginate($request->perPage));
    }
}
