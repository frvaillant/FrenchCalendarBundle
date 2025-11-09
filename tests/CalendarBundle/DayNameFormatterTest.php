<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Calendar\Formattter\DateNameFormatter;
use PHPUnit\Framework\TestCase;

class DayNameFormatterTest extends TestCase
{
    public function testFormatReturnsFrenchDayName(): void
    {
        $date = new \DateTime('2025-01-01'); // Wednesday -> mercredi
        $this->assertSame('mercredi', DateNameFormatter::format($date));
    }
}
