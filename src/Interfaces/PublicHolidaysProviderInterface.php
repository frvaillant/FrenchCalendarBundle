<?php

namespace Francoisvaillant\CalendarBundle\Interfaces;

use Francoisvaillant\CalendarBundle\Enum\Region;

interface PublicHolidaysProviderInterface
{
    public function getPublicHolidays(Region $region = Region::METROPOLE, ?int $year = null): array;

}
