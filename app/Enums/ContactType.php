<?php

namespace App\Enums;

enum ContactType: string
{
    case Customer      = 'customer';
    case Supplier      = 'supplier';
    case RoadHaulier   = 'road_haulier';
    case Airline       = 'airline';
    case RailOperator  = 'rail_operator';
    case ShippingLine  = 'shipping_line';

    public static function values(): array
    {
        return array_map(fn (self $t) => $t->value, self::cases());
    }
}
