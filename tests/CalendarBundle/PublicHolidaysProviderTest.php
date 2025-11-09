<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Calendar\PublicHolidaysProvider;
use Francoisvaillant\CalendarBundle\Enum\Region;
use PHPUnit\Framework\TestCase;

class PublicHolidaysProviderTest extends TestCase
{
    private function makeProvider(array $fixtures): PublicHolidaysProvider
    {
        return new class('http://example.test') extends PublicHolidaysProvider {
            public array $fixtures = [];
            public function __construct(string $url)
            {
                parent::__construct($url);
            }
            protected function fetchPublicHolidaysApi(int $year, Region $region): array
            {
                return $this->fixtures;
            }
        };
    }

    public function testGetPublicHolidaysFormatsKeysAndValues(): void
    {
        $fixtures = [
            '2025-01-01' => "Jour de l'An",
            '2025-04-21' => 'Lundi de Pâques',
        ];

        $provider = $this->makeProvider($fixtures);
        $provider->fixtures = $fixtures;

        $result = $provider->getPublicHolidays(Region::METROPOLE, 2025);
        $this->assertArrayHasKey('20250101', $result);
        $this->assertSame("Jour de l'An", $result['20250101']['name']);
        $this->assertSame('2025-01-01', $result['20250101']['date']);

        $this->assertArrayHasKey('20250421', $result);
        $this->assertSame('Lundi de Pâques', $result['20250421']['name']);
        $this->assertSame('2025-04-21', $result['20250421']['date']);
    }
}
