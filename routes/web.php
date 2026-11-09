<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

// Admin Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\VoucherCodeController as AdminVoucherController;
use App\Http\Controllers\Admin\PromotionController    as AdminPromotionController;
use App\Http\Controllers\Admin\UsageHistoryController;
use App\Http\Controllers\Admin\CashflowAnalysisController as AdminCashflowController;

// User Controllers
use App\Http\Controllers\User\AuthController       as UserAuthController;
use App\Http\Controllers\User\DashboardController  as UserDashboardController;
use App\Http\Controllers\User\VoucherController    as UserVoucherController;
use App\Http\Controllers\User\RedeemController      as UserRedeemController;
use App\Http\Controllers\User\InvoiceController     as UserInvoiceController;
use App\Http\Controllers\User\HistoryController     as UserHistoryController;
use App\Http\Controllers\User\PurchaseController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| User Frontend (Guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')
     ->prefix('user')
     ->name('user.')
     ->group(function () {
    Route::get('login',    [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login',   [UserAuthController::class, 'login']);
    Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register',[UserAuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| User Logout
|--------------------------------------------------------------------------
*/
Route::post('user/logout', [UserAuthController::class, 'logout'])
     ->middleware('auth')
     ->name('user.logout');

/*
|--------------------------------------------------------------------------
| User Protected (Authenticated + Role = user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'userakses:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

    // Dashboard
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Vouchers
    Route::get('vouchers', [UserVoucherController::class, 'index'])->name('vouchers.index');
    Route::get('vouchers/{voucher}', [UserVoucherController::class, 'show'])->name('vouchers.show');

    // Purchase
    Route::get('purchase/{voucher}', [PurchaseController::class, 'show'])->name('purchase.show'); // Perbaikan nama rute
    Route::post('purchase/{voucher}', [PurchaseController::class, 'process'])->name('purchase.process');

    // Redeem
    Route::get('redeem', [UserRedeemController::class, 'showForm'])->name('redeem.form');
    Route::post('redeem', [UserRedeemController::class, 'redeem'])->name('redeem.process');
    // Route::post('redeem', [UserRedeemController::class, 'redeem'])->name('user.redeem');

    // Invoice
    Route::get('invoice/{id}', [UserInvoiceController::class, 'show'])->name('invoice.show');

    // History
    Route::get('history', [UserHistoryController::class, 'index'])->name('history');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/register', [RegisterController::class, 'register'])->name('user.register');

/*
|--------------------------------------------------------------------------
| Global Admin & Auth Routes
|--------------------------------------------------------------------------
*/

// Admin Login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/',  [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

// Admin Logout
Route::post('/logout', [SesiController::class, 'logout'])->name('logout');

// Redirect /home → /admin/dashboard
// Route::get('home', fn() => redirect()->route('admin.dashboard'));

/*
|--------------------------------------------------------------------------
| Admin Backend (Authenticated + Role = admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'userakses:admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management (Admin only)
    Route::middleware('userakses:admin')->group(function () {
        Route::get('/users',        [UserController::class, 'index'])->name('users');
        Route::post('/users',       [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Voucher Management
    Route::get('vouchers', [AdminVoucherController::class, 'index'])->name('vouchers.index');
    Route::post('vouchers', [AdminVoucherController::class, 'store'])->name('vouchers.store');
    Route::put('vouchers/{voucher}', [AdminVoucherController::class, 'update'])->name('vouchers.update');
    Route::delete('vouchers/{voucher}', [AdminVoucherController::class, 'destroy'])->name('vouchers.destroy');
    Route::get('vouchers/{voucher}', [AdminVoucherController::class, 'show'])->name('vouchers.show');
    Route::get('vouchers/{voucher}/purchase', [AdminVoucherController::class, 'purchase'])->name('vouchers.purchase');
    Route::post('vouchers/{voucher}/buy', [AdminVoucherController::class, 'buy'])->name('vouchers.buy');


    // Promotion Management
    Route::get('/promotions',             [AdminPromotionController::class, 'index'])->name('promotions');
    Route::post('/promotions',            [AdminPromotionController::class, 'store'])->name('promotions.store');
    Route::put('/promotions/{promotion}', [AdminPromotionController::class, 'update'])->name('promotions.update');
    Route::delete('/promotions/{promotion}', [AdminPromotionController::class, 'destroy'])->name('promotions.destroy');

    // Usage History
    Route::get('/history',                   [UsageHistoryController::class, 'index'])->name('history');
    Route::post('/history',                  [UsageHistoryController::class, 'store'])->name('history.store');
    Route::put('/history/{history}',         [UsageHistoryController::class, 'update'])->name('history.update');
    Route::delete('/history/{history}',      [UsageHistoryController::class, 'destroy'])->name('history.destroy');

    // Cashflow Analysis
    Route::get('/cashflow',                  [AdminCashflowController::class, 'index'])->name('cashflow');
    Route::delete('/cashflow/{cashflow}',    [AdminCashflowController::class, 'destroy'])->name('cashflow.destroy');
    
    

});
