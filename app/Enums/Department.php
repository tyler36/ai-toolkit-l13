<?php

namespace App\Enums;

enum Department: string
{
    case SUPPORT = 'SUPPORT';
    case SALES = 'SALES';
    case ENGINEERING = 'ENGINEERING';
    case PRODUCT = 'PRODUCT';
    case OPS = 'OPS';
}
