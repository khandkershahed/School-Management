<?php

namespace App\Http\Controllers\Admin;

use App\Models\Asset;
use App\Models\Account;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoicePayment;
use App\Models\NonInvoicePayment;
use App\Http\Controllers\Controller;

class BalanceSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view("admin.pages.balanceSheet.index");
    // }

    // public function index()
    // {
    //     // total assets
    //     $assets = Asset::where('status', 1)->get()->sum('calculated_value');

    //     // inventory value
    //     // $inventoryValue = Product::where('status', 1)->get()->sum(function ($currentRow) {
    //     //     return $currentRow->purchase_price * $currentRow->inventory_count;
    //     // });

    //     // client dues
    //     $sales = Invoice::where('status', 1)->sum('sub_total');
    //     $salesTransportCost = Invoice::where('status', 1)->sum('transport');
    //     $salesDiscount = Invoice::where('status', 1)->sum('discount');
    //     $salesTax = Invoice::where('status', 1)->get()->sum('calculated_tax');
    //     $totalSales = $sales - $salesDiscount + $salesTransportCost + $salesTax;

    //     // invoice due
    //     $invoiceTotalPaid = InvoicePayment::where('status', 1)->sum('amount');
    //     $invoiceDue = $totalSales - $invoiceTotalPaid;

    //     // non invoice due
    //     $nonInvoiceTotal = NonInvoicePayment::where('type', 0)->where('status', 1)->sum('amount');
    //     $nonInvoicePaid = NonInvoicePayment::where('type', 1)->where('status', 1)->sum('amount');
    //     $nonInvoiceDue = $nonInvoiceTotal - $nonInvoicePaid;

    //     $clientTotalDue = $invoiceDue + $nonInvoiceDue;

    //     // bank balance
    //     $bankBalance = Account::where('status', 1)->get()->sum('available_balance');

    //     // supplier dues
    //     // $purchases = Purchase::where('status', 1)->sum('sub_total');
    //     // $purchaseTransportCost = Purchase::where('status', 1)->sum('transport');
    //     // $purchaseDiscount = Purchase::where('status', 1)->sum('discount');
    //     // $purchaseTax = Purchase::where('status', 1)->get()->sum('calculated_tax');
    //     // $totalPurchases = $purchases - $purchaseDiscount + $purchaseTransportCost + $purchaseTax;

    //     // purchase due
    //     // $purchaseTotalPaid = PurchasePayment::where('status', 1)->sum('amount');
    //     // $purchaseDue = $totalPurchases - $purchaseTotalPaid;

    //     // non purchase due
    //     // $nonPurchaseTotal = NonPurchasePayment::where('type', 0)->where('status', 1)->sum('amount');
    //     // $nonPurchasePaid = NonPurchasePayment::where('type', 1)->where('status', 1)->sum('amount');
    //     // $nonPurchaseDue = $nonPurchaseTotal - $nonPurchasePaid;

    //     // supplier due
    //     // $supplierTotalDue = $purchaseDue + $nonPurchaseDue;

    //     // loan due
    //     // $loanDue = LoanAuthority::where('status', 1)->get()->sum('due');

    //     $buisnessTotal = $assets  + $clientTotalDue + $bankBalance;
    //     // $buisnessTotal = $assets + $inventoryValue + $clientTotalDue + $bankBalance;
    //     $liabilities = 0;
    //     $totalAsset = $buisnessTotal - $liabilities;

    //     return view(
    //         "admin.pages.balanceSheet.index",
    //         compact([
    //             'assets' => round($assets, 2),
    //             // 'inventoryValue' => round($inventoryValue, 2),
    //             'clientTotalDue' => round($clientTotalDue, 2),
    //             'bankBalance' => round($bankBalance, 2),
    //             // 'supplierDue' => round($supplierTotalDue, 2),
    //             // 'loanDue' => round($loanDue, 2),
    //             'buisnessTotal' => round($buisnessTotal, 2),
    //             'liabilities' => round($liabilities, 2),
    //             'totalAsset' => round($totalAsset, 2),
    //         ])
    //     );
    // }

    public function index()
    {
        // Assets Calculation
        $assets = Asset::where('status', 'active')->get()->sum('calculated_value');
        // Sales Calculation
        $totalSales = $this->calculateTotalSales();
        // Client Dues Calculation
        $invoiceDue = $this->calculateInvoiceDue($totalSales);
        // Non-Invoice Dues Calculation
        $nonInvoiceDue = $this->calculateNonInvoiceDue();
        // Client Total Due
        $clientTotalDue = $invoiceDue + $nonInvoiceDue;
        // Bank Balance
        $bankBalance = Account::where('status', 'active')->get()->sum('available_balance');
        // Business Total
        $businessTotal = $assets + $clientTotalDue + $bankBalance;
        // Liabilities (currently 0)
        $liabilities = 0;
        // Total Asset (Business Total - Liabilities)
        $totalAsset = $businessTotal - $liabilities;
        return view("admin.pages.balanceSheet.index",
            compact(
                'assets',
                'clientTotalDue',
                'bankBalance',
                'businessTotal',
                'liabilities',
                'totalAsset'
            )
        );
    }

    private function calculateTotalSales()
    {
        $sales = Invoice::where('status', 'active')->sum('sub_total');
        $salesTransportCost = Invoice::where('status', 'active')->sum('transport');
        $salesDiscount = Invoice::where('status', 'active')->sum('discount');
        $salesTax = Invoice::where('status', 'active')->get()->sum('calculated_tax');
        return $sales - $salesDiscount + $salesTransportCost + $salesTax;
    }

    private function calculateInvoiceDue($totalSales)
    {
        $invoiceTotalPaid = InvoicePayment::where('status', 'active')->sum('amount');
        return $totalSales - $invoiceTotalPaid;
    }

    private function calculateNonInvoiceDue()
    {
        $nonInvoiceTotal = NonInvoicePayment::where('type', 0)->where('status', 'active')->sum('amount');
        $nonInvoicePaid = NonInvoicePayment::where('type', 1)->where('status', 'active')->sum('amount');
        return $nonInvoiceTotal - $nonInvoicePaid;
    }
}
