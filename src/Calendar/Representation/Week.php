<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Representation;

use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;

/**
 *
 * This class represents a week
 *
 */
class Week
{
    private array $dates;
    private int $number;
    public function __construct()
    {
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function setDates(array $dates): void
    {
        $this->dates = $dates;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;
        return $this;
    }
    public function getNumber(): int
    {
        return $this->number;
    }


}
