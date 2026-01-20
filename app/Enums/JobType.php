<?php

namespace App\Enums;

enum JobType: string
{
    case Import = 'import';
    case Export = 'export';
    case Domestic = 'domestic';
    case CrossTrade = 'cross_trade';

    public function label(): string
    {
        return match ($this) {
            self::Import => 'Import',
            self::Export => 'Export',
            self::Domestic => 'Domestic',
            self::CrossTrade => 'Cross Trade',
        };
    }

    public static function values(): array
    {
        return array_map(fn(self $t) => $t->value, self::cases());
    }
}
