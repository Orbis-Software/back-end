<?php

namespace App\Enums;

enum TransportMode: string
{
    case Air = 'air';
    case Sea = 'sea';
    case Road = 'road';
    case Rail = 'rail';
    case Courier = 'courier';
}
