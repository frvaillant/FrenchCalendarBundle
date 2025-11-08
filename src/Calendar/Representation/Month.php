<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Representation;

class Month
{
    private string $monthName;

    private array $weeks;

    public function getMonthName(): string
    {
        return $this->monthName;
    }

    public function setMonthName(string $monthName): void
    {
        $this->monthName = $monthName;
    }

    public function getWeeks(): array
    {
        return $this->weeks;
    }

    public function setWeeks(array $weeks): void
    {
        $this->weeks = $weeks;
    }


}
