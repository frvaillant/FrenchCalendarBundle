<?php

namespace Francoisvaillant\CalendarBundle\Enum;

enum MonthsOfYear: string
{
    case JANUARY   = 'janvier';
    case FEBRUARY  = 'février';
    case MARCH     = 'mars';
    case APRIL     = 'avril';
    case MAY       = 'mai';
    case JUNE      = 'juin';
    case JULY      = 'juillet';
    case AUGUST    = 'août';
    case SEPTEMBER = 'septembre';
    case OCTOBER   = 'octobre';
    case NOVEMBER  = 'novembre';
    case DECEMBER  = 'décembre';

    public static function values(): array
    {
        return array_map(fn(self $month) => ucfirst($month->value), self::cases());
    }

    public function code(): int
    {
        return match ($this) {
            self::JANUARY   => 1,
            self::FEBRUARY  => 2,
            self::MARCH     => 3,
            self::APRIL     => 4,
            self::MAY       => 5,
            self::JUNE      => 6,
            self::JULY      => 7,
            self::AUGUST    => 8,
            self::SEPTEMBER => 9,
            self::OCTOBER   => 10,
            self::NOVEMBER  => 11,
            self::DECEMBER  => 12,
            default => throw new \Exception('Invalid month'),
        };
    }
}
