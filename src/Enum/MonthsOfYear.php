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
}
