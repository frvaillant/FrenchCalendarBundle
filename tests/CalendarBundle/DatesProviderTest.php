<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Calendar\DatesProvider;
use PHPUnit\Framework\TestCase;

class DatesProviderTest extends TestCase
{
    public function testGetDatesStructureAndContentForYear2025(): void
    {
        $provider = new DatesProvider();
        $dates = $provider->getDates(2025);

        $this->assertIsArray($dates, 'Dates should be an array grouped by week numbers');
        $this->assertArrayHasKey(1, $dates, 'Week 1 should exist');

        // 2025-01-01 is Wednesday
        $this->assertArrayHasKey('20250101', $dates[1]);

        $day = $dates[1]['20250101'];
        $this->assertSame('Wednesday', $day->getDate()->format('l'));
        $this->assertSame('20250101', $day->getDate()->format('Ymd'));
        $this->assertIsInt($day->getWeekNumber());
        $this->assertIsInt($day->getDayNumber());
        $this->assertIsString($day->getDayName());
        $this->assertIsString($day->getDayNameFr());
        $this->assertFalse($day->isHoliday());
        $this->assertFalse($day->isPublicHoliday());
        $this->assertNull($day->getHolidayName());
        $this->assertNull($day->getPublicHolidayName());

        // The first Monday (2025-01-06) should be in week 2 with current implementation
        $this->assertArrayHasKey(2, $dates, 'Week 2 should exist');
        $this->assertArrayHasKey('20250106', $dates[2]);
        $this->assertSame(2, $dates[2]['20250106']->getWeekNumber());
    }
}
