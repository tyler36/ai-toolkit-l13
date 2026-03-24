<?php

namespace App\Enums;

enum TicketSentiment: string
{
  case POSITIVE = 'POSITIVE';
  case NEUTRAL = 'NEUTRAL';
  case NEGATIVE = 'NEGATIVE';
}
