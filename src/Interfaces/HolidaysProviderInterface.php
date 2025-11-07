<?php

namespace Francoisvaillant\CalendarBundle\Interfaces;

use Francoisvaillant\CalendarBundle\Enum\Zone;

interface HolidaysProviderInterface
{
    public function getHolidays(Zone $zone, ?int $year = null): array;

}
