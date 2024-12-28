<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\AccountTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BalanceAdjustmentController extends Controller
{


    public function index(Request $request)
    {
        $data = [
            'balances' => AccountTransaction::with('cashbookAccount', 'user')
                ->where(function ($query) {
                    $query->where('reason', 'LIKE', 'Non-invoice balance added%')
                        ->orWhere('reason', 'LIKE', 'Non-invoice balance removed from%');
                })
                ->latest()
                ->get(),
        ];
        return view("admin.pages.balance.index", $data);
    }

    public function create()
    {
        $data = [
            'accounts'   => Account::latest()->get(['id', 'bank_name', 'account_number']),
        ];
        return view("admin.pages.balance.create", $data);
    }


    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
            'account_id' => 'required',
            'amount'     => 'required|numeric|min:1',
            'date'       => 'nullable|date_format:Y-m-d',
            'note'       => 'nullable|string|max:255',
        ]);
        try {

            // generate reason
            $account = Account::findOrFail($request->account_id);

            // Generate reason based on the type
            $reason = ($request->type == 1)
                ? "Non-invoice balance added to $account->bank_name [$account->account_number]"
                : "Non-invoice balance removed from $account->bank_name [$account->account_number]";


            // store transaction
            AccountTransaction::create([
                'account_id'       => $request->account_id,
                'amount'           => $request->amount,
                'reason'           => $reason,
                'type'             => $request->type,
                'transaction_date' => $request->date,
                'created_by'       => Auth::guard('admin')->user()->id,
                'note'             => $request->note,
                'status'           => $request->status,
            ]);

            if ($request->type == 1) {
                # code...
            } else {
                # code...
            }


            redirectWithSuccess('Balance updated successfully');
            return redirect()->route('admin.balance-adjustment.index');
        } catch (Exception $e) {
            // redirectWithError($e->getMessage());
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }



    public function edit(string $slug)
    {
        $data = [
            'balanceAdjustment' => AccountTransaction::where('slug', $slug)->first(),
            'accounts'          => Account::latest()->get(['id', 'bank_name', 'account_number']),
        ];
        return view("admin.pages.balance.edit", $data);
    }

    public function update(Request $request, $slug)
    {
        $transaction = AccountTransaction::where('slug', $slug)->first();
        // validate request
        $this->validate($request, [
            'account' => 'required',
            'amount' => 'required|numeric|min:' . $transaction->amount,
            'date' => 'nullable|date_format:Y-m-d',
            'note' => 'nullable|string|max:255',
            'status' => 'required',
        ]);

        try {
            // generate reason
            $accountNumber = $request->account['accountNumber'];
            if ($request->type == 1) {
                $reason = "Non invoice balance added to [$accountNumber]";
            } else {
                $reason = "Non invoice balance removed from [$accountNumber]";
            }

            // update transaction
            $transaction->update([
                'amount' => $request->amount,
                'reason' => $reason,
                'type' => $request->type,
                'transaction_date' => $request->date,
                'note' => $request->note,
                'status' => $request->status,
            ]);

            return $this->responseWithSuccess('Balance updated successfully!');
        } catch (Exception $e) {
            return $this->responseWithError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        try {
            $transaction = AccountTransaction::with('cashbookAccount')->where('slug', $slug)->first();
            if ($transaction->amount <= $transaction->cashbookAccount->availableBalance()) {
                $transaction->delete();

                return $this->responseWithSuccess('Transaction deleted successfully');
            }

            return $this->responseWithError('Transaction can\'t be remove');
        } catch (Exception $e) {
            return $this->responseWithError($e->getMessage());
        }
    }

    /**
     * search resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request)
    {
        $term = $request->term;

        $allQuery = AccountTransaction::with('cashbookAccount', 'user')
            ->where('reason', 'LIKE', 'Non invoice balance added%')->where(function ($query) use ($term) {
                $query->orWhere('amount', 'LIKE', '%' . $term . '%')
                    ->orWhereHas('cashbookAccount', function ($newQuery) use ($term) {
                        $newQuery->where('bank_name', 'LIKE', '%' . $term . '%');
                        $newQuery->orWhere('account_number', 'LIKE', '%' . $term . '%');
                    });
            })->latest()->paginate($request->perPage);

        // return AccountTransactionResource::collection($allQuery);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allBalances()
    {
        $transactions = AccountTransaction::where('status', 1)->latest()->paginate(10);

        // return AccountTransactionResource::collection($transactions);
    }
}
