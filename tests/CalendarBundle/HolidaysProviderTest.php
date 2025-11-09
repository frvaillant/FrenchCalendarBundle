<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Calendar\HolidaysProvider;
use Francoisvaillant\CalendarBundle\Enum\Zone;
use PHPUnit\Framework\TestCase;

class HolidaysProviderTest extends TestCase
{
    private function makeProvider(array $fixtures): HolidaysProvider
    {
        return new class('http://example.test') extends HolidaysProvider {
            public array $fixtures = [];
            public function __construct(string $url)
            {
                parent::__construct($url);
            }
            protected function fetchHolidaysApi($year, $zone): ?array
            {
                return $this->fixtures;
            }
        };
    }

    public function testGetHolidaysBuildsCorrectStructureAndAdjustsStartDate(): void
    {
        $fixtures = [
            [
                'description' => "Vacances d'Hiver",
                'start_date' => '2025-02-22T23:00:00+00:00',
                'end_date' => '2025-03-09T23:00:00+00:00',
                'zones' => 'Zone A',
            ],
            [
                'description' => 'Vacances de Printemps',
                'start_date' => '2025-04-18T23:00:00+00:00',
                'end_date' => '2025-05-04T23:00:00+00:00',
                'zones' => 'Zone A',
            ],
        ];

        $provider = $this->makeProvider($fixtures);
        $provider->fixtures = $fixtures;

        $holidays = $provider->getHolidays(Zone::ZONE_A, 2025);
        $this->assertArrayHasKey("Vacances d'Hiver", $holidays);
        $winter = $holidays["Vacances d'Hiver"];
        $this->assertSame('20250223', $winter['start_key'], 'Start date should be incremented by 1 day');
        $this->assertSame('20250309', $winter['end_key']);
        $this->assertSame('Zone A', $winter['zones']);
    }

    public function testGetFlattenHolidays(): void
    {
        $fixtures = [
            [
                'description' => 'Vacances Test',
                'start_date' => '2025-12-20T23:00:00+00:00',
                'end_date' => '2025-12-22T23:00:00+00:00',
                'zones' => 'Zone A',
            ],
        ];

        $provider = $this->makeProvider($fixtures);
        $provider->fixtures = $fixtures;

        $flat = $provider->getFlattenHolidays(Zone::ZONE_A, 2025);

        // start_key should be 20251221 due to +1 day logic in build
        $this->assertSame(
            [
                '20251221' => 'Vacances Test',
                '20251222' => 'Vacances Test',
            ],
            $flat
        );
    }
}
