<?php

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
