<?php

namespace App\Http\Controllers;

use App\Ai\Agents\TicketTriager;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketTriageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Ticket $ticket)
    {
        try {
            $response = (new TicketTriager())->prompt(
                "Subject: {$ticket->subject}\n\n{$ticket->body}"
            );

            $ticket->update([
                'priority' => $response['priority'],
                'department' => Str::upper($response['department']),
                'sentiment' => Str::upper($response['sentiment']),
                'ai_tags' => $response['tags'],
            ]);

            return response()->json([
                'status' => 'ok',
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            // Handle exceptions, log errors, etc.
            dd("Error triaging ticket: " . $e->getMessage());
        }
    }
}
