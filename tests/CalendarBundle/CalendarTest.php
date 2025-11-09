<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Calendar\Calendar;
use Francoisvaillant\CalendarBundle\Calendar\DatesProvider;
use Francoisvaillant\CalendarBundle\Calendar\Representation\Month;
use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testFormatAsWeeksAndChosenWeek(): void
    {
        $dates = (new DatesProvider())->getDates(2025);

        $calendar = new Calendar();
        $calendar->setDates($dates);
        $calendar->setFormat(Calendar::AS_WEEKS);

        $weeks = $calendar->getCalendar(1);
        $this->assertCount(1, $weeks, 'Chosen week filtering should return only one week');
        $week = reset($weeks);

        // Ensure all day codes exist (1..6 and 0)
        $this->assertSame(DaysOfWeek::codes(), array_keys($week));
        $weekData = array_filter($week, fn($d) => $d !== null);
        $first = reset($weekData);

        // Week 1 of 2025 should contain Jan 1st (Wednesday), codes 1..0 present, some may be null
        $this->assertEquals('20250101', $first->getDate()->format('Ymd'));
    }

    public function testFormatAsMonthsAndChosenMonth(): void
    {
        $dates = (new DatesProvider())->getDates(2025);

        $calendar = new Calendar();
        $calendar->setDates($dates);
        $calendar->setFormat(Calendar::AS_MONTHS);

        $months = $calendar->getCalendar(1); // January
        $this->assertCount(1, $months);
        $january = $months[1];
        $this->assertIsArray($january['weeks']);
        $this->assertTrue($january['month'] instanceof Month);
        $this->assertTrue($january['month']->localName() === 'Janvier');
        $this->assertTrue($january['month']->localName('en_EN') === 'January');

        $found = false;
        foreach ($january['weeks'] as $week) {
            foreach ($week as $day) {
                if ($day && $day->getDate()->format('Ymd') === '20250101') {
                    $found = true; break 2;
                }
            }
        }
        $this->assertTrue($found, 'January should contain 2025-01-01');
    }

    public function testAsDaysReturnsRawDates(): void
    {
        $dates = (new DatesProvider())->getDates(2025);
        $calendar = new Calendar();
        $calendar->setDates($dates);
        $calendar->setFormat(Calendar::AS_DAYS);

        $raw = $calendar->getCalendar();
        $this->assertSame($dates, $raw);
    }
}
