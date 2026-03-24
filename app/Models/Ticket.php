<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\TicketSentiment;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'state',
        'priority',
        'sentiment',
        'department',
        'ai_tags',
        'user_id',
        'closed_at',
    ];

    protected $casts = [
        'state' => TicketStatus::class,
        'priority' => Priority::class,
        'sentiment' => TicketSentiment::class,
        'ai_tags' => 'array',
        'closed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('state', 'OPEN');
    }

    public function scopeClosed($query)
    {
        return $query->where('state', 'CLOSED');
    }
}
