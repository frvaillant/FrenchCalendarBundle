<?php

namespace Francoisvaillant\CalendarBundle\Interfaces;

use Francoisvaillant\CalendarBundle\Enum\Region;
use Francoisvaillant\CalendarBundle\Enum\Zone;

interface CalendarInterface
{
    public function getCalendar(Zone $zone, Region $region = Region::METROPOLE, ?int $year = null);

}
