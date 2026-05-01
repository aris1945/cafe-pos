<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'kasir') {
        return redirect()->route('kasir.pos');
    }
    return redirect()->route('admin.reports.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/categories', \App\Livewire\Admin\ManageCategories::class)->name('categories');
    Route::get('/menus', \App\Livewire\Admin\ManageMenus::class)->name('menus');
    Route::get('/kasir', \App\Livewire\Admin\ManageKasir::class)->name('kasir');
    Route::get('reports', \App\Livewire\Admin\ReportDashboard::class)->name('reports.index');
    Route::get('reports/export', [\App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');
});

// Kasir routes
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/pos', \App\Livewire\Kasir\PosTerminal::class)->name('pos');
    Route::get('/transactions', function () {
        return 'Riwayat Transaksi (WIP)'; })->name('transactions.index');
});

// Payment
Route::middleware('auth')->prefix('payment')->name('payment.')->group(function () {
    Route::post('create/{order}', [PaymentController::class, 'create'])->name('create');
    Route::post('cash/{order}', [PaymentController::class, 'processCash'])->name('cash');
    Route::post('midtrans/callback', [PaymentController::class, 'midtransCallback'])->name('midtrans.callback')->withoutMiddleware(['auth']);
    Route::get('success/{order}', [PaymentController::class, 'success'])->name('success');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
