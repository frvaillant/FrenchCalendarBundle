<?php

namespace App\Tests\CalendarBundle;

use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;
use Francoisvaillant\CalendarBundle\Enum\MonthsOfYear;
use PHPUnit\Framework\TestCase;

class EnumsTest extends TestCase
{
    public function testDaysOfWeekValuesAndCodes(): void
    {
        $values = DaysOfWeek::values();
        $this->assertCount(7, $values);
        $this->assertSame(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'], $values);

        $codes = DaysOfWeek::codes();
        $this->assertSame([1,2,3,4,5,6,0], $codes);
        $this->assertSame(1, DaysOfWeek::MONDAY->code());
        $this->assertSame(0, DaysOfWeek::SUNDAY->code());
    }

    public function testMonthsOfYearValuesAndCodes(): void
    {
        $values = MonthsOfYear::values();
        $this->assertCount(12, $values);
        $this->assertSame('janvier', strtolower($values[0]));
        $this->assertSame(1, MonthsOfYear::JANUARY->code());
        $this->assertSame(12, MonthsOfYear::DECEMBER->code());
    }
}
