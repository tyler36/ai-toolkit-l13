<?php

use App\Http\Controllers\TicketChatController;
use App\Http\Controllers\TicketTriageController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

Route::get('/ticket', function () {
    return view('ticket.index')
        ->with('tickets', Ticket::all()
    );
});

Route::get('/ticket/{ticket}', function (Ticket $ticket) {
    return view('ticket.show')
        ->with('ticket', $ticket);
});


Route::post('/ticket/{ticket}/ai/triage', TicketTriageController::class)->name('ticket.ai.triage');
Route::post('/ticket/{ticket}/ai/chat', TicketChatController::class)->name('ticket.ai.chat');
