<?php

namespace App\Enums;

enum JobStatus: string
{
    case Draft = 'draft';
    case Booked = 'booked';
    case InTransit = 'in_transit';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
