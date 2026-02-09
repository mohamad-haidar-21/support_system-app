<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Support\AuthController as SupportAuth;
use App\Http\Controllers\Support\DashboardController;
use App\Http\Controllers\Support\ConversationController as SupportConversation;
use App\Http\Controllers\Support\TicketController as SupportTicket;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/users/{user}/toggle', [UserController::class, 'toggle']);
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');


    });
    Route::get('/support/login', [SupportAuth::class, 'showLogin'])->name('support.login');
Route::post('/support/login', [SupportAuth::class, 'login']);
Route::post('/support/logout', [SupportAuth::class, 'logout'])->name('support.logout');

Route::middleware(['auth', 'support'])->prefix('support')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('support.dashboard');

    Route::get('/conversations/{conversation}', [SupportConversation::class, 'show'])->name('support.conversations.show');
    Route::post('/conversations/{conversation}/take', [SupportConversation::class, 'take'])->name('support.conversations.take');
    Route::post('/conversations/{conversation}/send', [SupportConversation::class, 'send'])->name('support.conversations.send');
    Route::post('/conversations/{conversation}/close', [SupportConversation::class, 'close'])->name('support.conversations.close');

    Route::get('/tickets/{ticket}', [SupportTicket::class, 'show'])->name('support.tickets.show');
    Route::post('/tickets/{ticket}/status', [SupportTicket::class, 'status'])->name('support.tickets.status');
});
