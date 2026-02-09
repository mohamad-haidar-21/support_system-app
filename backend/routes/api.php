<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketAttachmentController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

//direct chat
Route::post('/conversations/direct', [App\Http\Controllers\Api\ConversationController::class, 'createDirect']);

//list conversations
Route::get('/conversations', [ConversationController::class, 'index']);
Route::get('/conversations/{conversation}', [ConversationController::class, 'show']);

//support take a chat
Route::post('/conversations/{conversation}/take', [ConversationController::class, 'take']);

//close conversation
Route::post('/conversations/{conversation}/close', [ConversationController::class, 'close']);

//messages
Route::get('/conversations/{conversation}/messages', [MessageController::class, 'index']);
Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);

// Tickets
Route::post('/tickets', [TicketController::class, 'store']);
Route::get('/tickets/my', [TicketController::class, 'myTickets']);
Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

// Support/Admin tickets list
Route::get('/tickets', [TicketController::class, 'index']);
Route::post('/tickets/{ticket}/take', [TicketController::class, 'take']);
Route::post('/tickets/{ticket}/status', [TicketController::class, 'updateStatus']);

// Attachments (customer uploads to ticket card)
Route::post('/tickets/{ticket}/attachments', [TicketAttachmentController::class, 'store']);

Route::prefix('admin')->group(function(){
    Route::post('/users', [AdminController::class, 'createUser']);
    Route::get('/users', [AdminController::class, 'listUsers']);
    Route::patch('/users/{user}/active', [AdminController::class, 'setActive']);
    Route::post('/users/{user}/reset-password', [AdminController::class, 'resetPassword']);
});
});