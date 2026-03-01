<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PayslipController as AdminPayslipController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Cashier\OrderController as CashierOrderController;
use App\Http\Controllers\Cashier\PaymentController as CashierPaymentController;
use App\Http\Controllers\Cook\OrderController as CookOrderController;
use App\Http\Controllers\Staff\PayslipController as StaffPayslipController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('menu-items', MenuItemController::class)->except(['show']);
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::resource('staff', StaffController::class)->only(['index', 'store', 'update']);
        Route::get('payslips', [AdminPayslipController::class, 'index'])->name('payslips.index');
        Route::get('payslips/create', [AdminPayslipController::class, 'create'])->name('payslips.create');
        Route::post('payslips', [AdminPayslipController::class, 'store'])->name('payslips.store');
        Route::post('payslips/{payslip}/paid', [AdminPayslipController::class, 'markPaid'])->name('payslips.markPaid');
        Route::get('reports', AdminReportController::class)->name('reports');
    });

    Route::middleware('role:cashier')->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('orders', [CashierOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [CashierOrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [CashierOrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [CashierOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/confirm', [CashierOrderController::class, 'confirm'])->name('orders.confirm');
        Route::get('payments', [CashierPaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/order/{order}', [CashierPaymentController::class, 'create'])->name('payments.create');
        Route::post('payments', [CashierPaymentController::class, 'store'])->name('payments.store');
        Route::get('payments/receipt/{order}', [CashierPaymentController::class, 'receipt'])->name('payments.receipt');
    });

    Route::middleware('role:cook')->prefix('cook')->name('cook.')->group(function () {
        Route::get('orders', [CookOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/completed', [CookOrderController::class, 'completed'])->name('orders.completed');
        Route::patch('orders/{order}/status', [CookOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/confirm', [CookOrderController::class, 'confirm'])->name('orders.confirm');
    });

    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('payslips', [StaffPayslipController::class, 'index'])->name('payslips.index');
        Route::get('payslips/{payslip}', [StaffPayslipController::class, 'show'])->name('payslips.show');
    });
});
