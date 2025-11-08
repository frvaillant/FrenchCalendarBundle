<?php

namespace Francoisvaillant\CalendarBundle\Twig;

use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DaysOfWeekExtension extends  AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('days_of_week', [$this, 'getDaysOfWeek']),
        ];
    }

    public function getDaysOfWeek(): array
    {
        return DaysOfWeek::values();
    }

}
