<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;

// Portfolio homepage
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');

// Contact form: POST only (AJAX submission from modal)
Route::post('/contact', [PortfolioController::class, 'submitContact'])->name('contact.submit');

// Redirect GET /contact → homepage (handles accidental direct browser navigation)
Route::get('/contact', fn() => redirect('/'))->name('contact.redirect');

// Sample Pages
Route::get('/sample/lead-generation', [PortfolioController::class, 'leadSample'])->name('sample.lead');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password reset dummy route (optional, keeps the link working)
Route::get('/forgot-password', function () {
    return 'Password reset functionality is not configured yet.';
})->name('password.request');

// Admin Auth Routes (Protected by session-based auth)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/leads', [AdminController::class, 'leads'])->name('leads');
    Route::get('/leads/{lead}', [AdminController::class, 'show'])->name('leads.show');
    Route::patch('/leads/{lead}/status', [AdminController::class, 'updateStatus'])->name('leads.status');
    Route::delete('/leads/{lead}', [AdminController::class, 'destroy'])->name('leads.destroy');
    Route::post('/leads/bulk-delete', [AdminController::class, 'bulkDestroy'])->name('leads.bulk');
    Route::get('/export', [AdminController::class, 'export'])->name('export');
});
