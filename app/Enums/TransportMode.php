<?php

namespace App\Enums;

enum TransportMode: string
{
    case Air = 'air';
    case Sea = 'sea';
    case Road = 'road';
    case Rail = 'rail';
    case Courier = 'courier';

    /**
     * Human-readable label (UI / logs)
     */
    public function label(): string
    {
        return match ($this) {
            self::Air     => 'Air Freight',
            self::Sea     => 'Sea Freight',
            self::Road    => 'Road Transport',
            self::Rail    => 'Rail Transport',
            self::Courier => 'Courier',
        };
    }

    /**
     * For validation rules
     */
    public static function values(): array
    {
        return array_map(
            fn (self $mode) => $mode->value,
            self::cases()
        );
    }
}
