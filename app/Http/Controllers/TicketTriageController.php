<?php

namespace App\Http\Controllers;

use App\Ai\Agents\TicketTriager;
use App\Models\AiRun;
use App\Models\AiUsage;
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
        $run = AiRun::create([
            'user_id' => $request->user()->id ?? 1,
            'ticket_id' => $ticket->id,
            'feature_key' => 'ticket_triage',
            'status' => 'running',
            'provider' => 'ollama',
            'model' => null,
            'input_hash' => sha1($ticket->subject . '|' . $ticket->body),
            'started_at' => now(),
        ]);

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

            $run->update([
                'status' => 'completed',
                'finished_at' => now(),
            ]);

            if(isset($response->usage)) {
                $usage =$response->usage;

                AiUsage::create([
                    'ai_run_id' => $run->id,
                    'prompt_tokens' => $usage->promptTokens ?? 0,
                    'completion_tokens' => $usage->completionTokens ?? 0,
                    'total_tokens' => $usage->totalTokens ?? 0,
                    'cost_jpy' => $usage->costJpy ?? 0,
                ]);
            }

            return response()->json([
                'status' => 'ok',
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            $run->update([
                'status' => 'failed',
                'finished_at' => now(),
                'error_message' => $e->getMessage()
            ]);

            throw $e;
        }
    }
}
