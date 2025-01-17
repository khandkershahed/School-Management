<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\IconController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DealBannerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\TableExportController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\PageBannerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\StudentFeeController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\TodayReportController;
use App\Http\Controllers\Admin\BalanceSheetController;
use App\Http\Controllers\Admin\EmailSettingController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\ExpenseReportController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\SummaryReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\BalanceTransferController;
use App\Http\Controllers\Admin\EducationMediumController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\SalesUserReportController;
use App\Http\Controllers\Admin\StockManagementController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\ClientNonInvoiceController;
use App\Http\Controllers\Admin\CollectionReportController;
use App\Http\Controllers\Admin\StudentFeeWaiverController;
use App\Http\Controllers\Admin\BalanceAdjustmentController;
use App\Http\Controllers\Admin\IncomeSubCategoryController;
use App\Http\Controllers\Admin\TermsAndConditionController;
use App\Http\Controllers\Admin\EmployeeDepartmentController;
use App\Http\Controllers\Admin\ExpenseSubCategoryController;
use App\Http\Controllers\Admin\ShippingManagementController;
use App\Http\Controllers\Admin\TransactionHistoryController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\ClientPayableReportController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\ClientReceivableReportController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\ReportController;

Route::get('/', function () {
    return redirect()->route('admin.login');
})->name('home');

Route::middleware('guest:admin')->name('admin.')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Route::get('/dashboard', [AdminController::class, 'dashboard'])
//     ->middleware(['auth:admin', 'verified'])
//     ->name('admin.dashboard');

Route::middleware('auth:admin')->name('admin.')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('check-password', [PasswordController::class, 'checkPassword'])->name('checkPassword');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['verified'])->name('dashboard');


    // Route::resources(
    //     [

    //     ],
    //     ['except' => ['show', 'create', 'edit', 'store', 'update', 'destroy']]
    // );
    Route::resources(
        [
            'education-medium'     => EducationMediumController::class,
        ],
        ['except' => ['show', 'create', 'edit']] // exclude 'show' and 'edit', but allow 'create'
    );
    Route::resources(
        [
            'employee'             => EmployeeController::class,
            'role'                 => RoleController::class,
            'permission'           => PermissionController::class,
            'email-settings'       => EmailSettingController::class,
        ],
        ['except' => ['show']]
    );
    Route::resources(
        [
            'staff'                 => StaffController::class, //done
            'newsletters'           => NewsletterController::class,
            'contacts'              => ContactController::class,
            'students'              => StudentController::class,
            'fees'                  => FeeController::class,
            'student-fee'           => StudentFeeController::class,
            'fee-waiver'            => StudentFeeWaiverController::class,
        ],
    );
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/admin/fee-reports', [AccountsController::class, 'index'])->name('fee-reports');



    // Filtering
    Route::get('student/filter', [StudentFeeController::class, 'filter'])->name('student.filter');
    Route::get('invoice/list', [AccountsController::class, 'invoiceList'])->name('invoice.list');
    Route::delete('invoice/{id}/delete', [AccountsController::class, 'invoiceDelete'])->name('invoice.destroy');

    Route::post('/fetch-student-data', [StudentController::class, 'fetchStudentData'])->name('fetch.student.data');


    //Reports
    Route::get('report/daily-transaction', [ReportController::class, 'dailyTransaction'])->name('report.daily-transaction');
    Route::get('report/daily-netincome', [ReportController::class, 'dailynetIncome'])->name('report.daily-netincome');
    Route::get('report/daily-ledger', [ReportController::class, 'dailyLedger'])->name('report.daily-ledger');
    Route::get('report/monthlydue', [ReportController::class, 'monthlyDue'])->name('report.monthlydue');

    Route::get('report/duefee', [ReportController::class, 'dueFee'])->name('report.duefee');
    Route::get('report/studentdue', [ReportController::class, 'studentDue'])->name('report.studentdue');
    Route::get('report/studentinvoice', [ReportController::class, 'studentInvoice'])->name('report.studentinvoice');
    Route::get('report/income', [ReportController::class, 'income'])->name('report.income');
    Route::get('report/accounting-balance', [ReportController::class, 'accountingBalance'])->name('report.accountingbalance');
    Route::get('report/customreport', [ReportController::class, 'customReport'])->name('report.customreport');





    Route::get('active-mail-configuration', [EmailSettingController::class, 'activeMailConfiguration'])->name('active.mail.configuration');
    Route::put('email-settings', [EmailSettingController::class, 'emailUpdateOrCreate'])->name('email.settings.updateOrCreate');
    Route::post('send-test-mail', [EmailSettingController::class, 'sendTestMail'])->name('send.test.mail');

    Route::post('email-settings/toggle-status/{id}', [EmailSettingController::class, 'toggleStatus'])->name('email-settings.toggle-status');

    Route::get('/database/backup', [Controller::class, 'databaseBackup'])->name('database.backup');
    Route::get('/backup', [Controller::class, 'downloadBackup'])->name('database.download');

    Route::get('role/{roleId}/give-permission', [RoleController::class, 'givePermission'])->name('role.give-permission');
    Route::patch('role/{roleId}/give-permission', [RoleController::class, 'storePermission'])->name('role.store-permission');

    Route::get('log', [LogController::class, 'index'])->name('log.index');
    Route::get('log/{id}', [LogController::class, 'show'])->name('log.show');
    Route::delete('log/{id}', [LogController::class, 'destroy'])->name('log.destroy');
    Route::get('log/download/{id}', [LogController::class, 'download'])->name('log.download');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'updateOrcreateSetting'])->name('settings.updateOrCreate');

    // Bulk Delete
    // web.php
    // Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');






    // PDF

    Route::get('/setup/brands/pdf', [TableExportController::class, 'brandsPDF'])->name('brands.pdf');
    Route::get('/setup/currencies/pdf', [TableExportController::class, 'currenciesPDF'])->name('currencies.pdf');
    Route::get('/setup/units/pdf', [TableExportController::class, 'unitsPDF'])->name('units.pdf');
    Route::get('/setup/vat-rates/pdf', [TableExportController::class, 'vatRatesPDF'])->name('vatRates.pdf');
    Route::get('/setup/roles/pdf', [TableExportController::class, 'rolesPDF'])->name('roles.pdf');
    Route::get('/setup/payment-methods/pdf', [TableExportController::class, 'paymentMethodsPDF'])->name('paymentMethods.pdf');

    Route::get('/expense-categories/pdf', [TableExportController::class, 'expCategoriesPDF'])->name('expCategories.pdf');
    Route::get('/expense-sub-categories/pdf', [TableExportController::class, 'expSubCategoriesPDF'])->name('expSubCategories.pdf');
    Route::get('/expenses/pdf', [TableExportController::class, 'expensesPDF'])->name('expenses.pdf');

    Route::get('/purchases/pdf', [TableExportController::class, 'purchasesPDF'])->name('purchases.pdf');
    Route::get('/purchase-returns/pdf', [TableExportController::class, 'purchaseReturnsPDF'])->name('purchaseReturns.pdf');

    Route::get('/quotations/pdf', [TableExportController::class, 'quotationsPDF'])->name('quotations.pdf');
    Route::get('/invoices/pdf', [TableExportController::class, 'invoicePDF'])->name('invoices.pdf');
    Route::get('/invoice-returns/pdf', [TableExportController::class, 'invoiceReturnPDF'])->name('invoiceReturns.pdf');

    Route::get('/accounts/pdf', [TableExportController::class, 'accountsPDF'])->name('accounts.pdf');
    Route::get('/account-transactions/pdf/{slug}', [TableExportController::class, 'accountTransactionsPDF'])->name('account.transactions.pdf');
    Route::get('/cashbook/balance-adjustments/pdf', [TableExportController::class, 'nonInvoiceBalancesPDF'])->name('account.balances.pdf');
    Route::get('/cashbook/transfer-balances/pdf', [TableExportController::class, 'transferBalancesPDF'])->name('account.transferBalances.pdf');
    Route::get('/cashbook/transactions/pdf', [TableExportController::class, 'transactionsPDF'])->name('transactions.pdf');

    Route::get('/payments/clients/non-invoice/pdf', [TableExportController::class, 'nonInvoicePaymentsPDF'])->name('nonInvoicePayments.pdf');
    Route::get('/payments/clients/invoice/pdf', [TableExportController::class, 'invoicePaymentsPDF'])->name('invoicePayments.pdf');
    Route::get('/payments/suppliers/non-purchase/pdf', [TableExportController::class, 'nonPurchasePaymentsPDF'])->name('nonPurchasePayments.pdf');
    Route::get('/payments/suppliers/purchase/pdf', [TableExportController::class, 'purchasePaymentsPDF'])->name('locSupplierPayments.pdf');

    Route::get('/loan-authorities/pdf', [TableExportController::class, 'loanAuthoritiesPDF'])->name('loanAuthorities.pdf');
    Route::get('/loans/pdf', [TableExportController::class, 'loansPDF'])->name('loans.pdf');
    Route::get('/loan-payments/pdf', [TableExportController::class, 'loanPaymentsPDF'])->name('loanPayments.pdf');

    Route::get('/asset-types/pdf', [TableExportController::class, 'assetTypesPDF'])->name('assetTypes.pdf');
    Route::get('/assets/pdf', [TableExportController::class, 'assetsPDF'])->name('assets.pdf');

    Route::get('/payroll/pdf', [TableExportController::class, 'payrollPDF'])->name('payroll.pdf');

    Route::get('/clients/download/pdf', [TableExportController::class, 'clientsPDF'])->name('clients.pdf');
    Route::get('/suppliers/pdf', [TableExportController::class, 'suppliersPDF'])->name('suppliers.pdf');

    Route::get('/departments/pdf', [TableExportController::class, 'departmentsPDF'])->name('departments.pdf');
    Route::get('/employees/pdf', [TableExportController::class, 'employeesPDF'])->name('employees.pdf');
    Route::get('/increments/pdf', [TableExportController::class, 'incrementsPDF'])->name('increments.pdf');

    Route::get('/product-categories/pdf', [TableExportController::class, 'productCategoriesPDF'])->name('productCategories.pdf');
    Route::get('/product-sub-categories/pdf', [TableExportController::class, 'productSubCategoriesPDF'])->name('productSubCategories.pdf');
    Route::get('/products/pdf', [TableExportController::class, 'productsPDF'])->name('products.pdf');

    Route::get('/inventory-adjustments/pdf', [TableExportController::class, 'inventoryAdjustmentsPDF'])->name('inventoryAdjustments.pdf');
    Route::get('/non-zero-inventory/pdf', [TableExportController::class, 'nonZeroInventoryPDF'])->name('nonZeroInventory.pdf');
});
