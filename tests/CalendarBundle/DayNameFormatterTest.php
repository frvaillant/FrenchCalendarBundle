<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Calendar\Formattter\DayNameFormatter;
use PHPUnit\Framework\TestCase;

class DayNameFormatterTest extends TestCase
{
    public function testFormatReturnsFrenchDayName(): void
    {
        $date = new \DateTime('2025-01-01'); // Wednesday -> mercredi
        $this->assertSame('mercredi', DayNameFormatter::format($date));
    }
}
