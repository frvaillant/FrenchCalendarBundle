<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Calendar\CalendarProvider;
use Francoisvaillant\CalendarBundle\Calendar\DatesProvider;
use Francoisvaillant\CalendarBundle\Calendar\HolidaysProvider;
use Francoisvaillant\CalendarBundle\Calendar\PublicHolidaysProvider;
use Francoisvaillant\CalendarBundle\Enum\Region;
use Francoisvaillant\CalendarBundle\Enum\Zone;
use PHPUnit\Framework\TestCase;

class CalendarProviderTest extends TestCase
{
    private function findDayByKey(array $daysByWeeks, string $key): ?object
    {
        foreach ($daysByWeeks as $week) {
            if (isset($week[$key])) {
                return $week[$key];
            }
        }
        return null;
    }

    public function testGetCalendarMergesPublicHolidaysAndHolidays(): void
    {
        $datesProvider = new DatesProvider();
        $dates = $datesProvider->getDates(2025);

        $fakePublic = new class('http://example') extends PublicHolidaysProvider {
            public array $map = [];
            public function __construct(string $url) { parent::__construct($url); }
            public function getPublicHolidays(Region $region = Region::METROPOLE, ?int $year = null): array
            { return $this->map; }
        };
        $fakePublic->map = [
            '20250101' => ['name' => "Jour de l'An", 'date' => '2025-01-01'],
        ];

        $fakeHol = new class('http://example') extends HolidaysProvider {
            public array $flat = [];
            public function __construct(string $url) { parent::__construct($url); }
            public function getFlattenHolidays(Zone $zone, ?int $year = null): array
            { return $this->flat; }
        };

        $fakeHol->flat = [
            '20250102' => 'Vacances Test',
            '20250103' => 'Vacances Test',
        ];

        $provider = new CalendarProvider(new DatesProvider(), $fakePublic, $fakeHol);
        $calendar = $provider->getCalendar(Zone::ZONE_A, Region::METROPOLE, 2025);

        // Switch to raw days format for easy inspection
        $calendar->setFormat(\Francoisvaillant\CalendarBundle\Calendar\Calendar::AS_DAYS);
        $raw = $calendar->getCalendar();

        $jan1 = $this->findDayByKey($raw, '20250101');
        $this->assertNotNull($jan1, 'Jan 1st should exist');
        $this->assertTrue($jan1->isPublicHoliday());
        $this->assertSame("Jour de l'An", $jan1->getPublicHolidayName());

        $jan2 = $this->findDayByKey($raw, '20250102');
        $this->assertNotNull($jan2);
        $this->assertTrue($jan2->isHoliday());
        $this->assertSame('Vacances Test', $jan2->getHolidayName());

        $jan4 = $this->findDayByKey($raw, '20250104');
        $this->assertNotNull($jan4);
        $this->assertFalse($jan4->isPublicHoliday());
        $this->assertFalse($jan4->isHoliday());
    }
}
