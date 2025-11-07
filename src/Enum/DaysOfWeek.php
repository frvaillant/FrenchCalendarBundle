<?php

namespace Francoisvaillant\CalendarBundle\Enum;

enum DaysOfWeek: string
{
    case MONDAY    = 'lundi';
    case TUESDAY   = 'mardi';
    case WEDNESDAY = 'mercredi';
    case THURSDAY  = 'jeudi';
    case FRIDAY    = 'vendredi';
    case SATURDAY  = 'samedi';
    case SUNDAY    = 'dimanche';

    public static function values(): array
    {
        return array_map(fn(self $day) => ucfirst($day->value), self::cases());
    }

    public function code(): int
    {
        return match ($this) {
            self::MONDAY    => 1,
            self::TUESDAY   => 2,
            self::WEDNESDAY => 3,
            self::THURSDAY  => 4,
            self::FRIDAY    => 5,
            self::SATURDAY  => 6,
            self::SUNDAY    => 0,
        };
    }

    public static function codes(): array
    {
        return array_map(fn(self $day) => $day->code(), self::cases());
    }
}

