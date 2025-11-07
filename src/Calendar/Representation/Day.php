<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Representation;

class Day
{


    private \DateTime $date;
    private int $weekNumber;
    private int $dayNumber;
    private string $dayName;
    private string $dayNameFr;
    private bool $isPublicHoliday;
    private ?string $publicHolidayName;
    private bool $isHoliday;
    private ?string $holidayName;

    public function __construct()
    {
    }

    public function getWeekNumber(): int
    {
        return $this->weekNumber;
    }

    public function setWeekNumber(int $weekNumber): self
    {
        $this->weekNumber = $weekNumber;
        return $this;
    }

    public function getDayNumber(): int
    {
        return $this->dayNumber;
    }

    public function setDayNumber(int $dayNumber): self
    {
        $this->dayNumber = $dayNumber;
        return $this;
    }

    public function getDayName(): string
    {
        return $this->dayName;
    }

    public function setDayName(string $dayName): self
    {
        $this->dayName = $dayName;
        return $this;
    }

    public function getDayNameFr(): string
    {
        return $this->dayNameFr;
    }

    public function setDayNameFr(string $dayNameFr): self
    {
        $this->dayNameFr = $dayNameFr;
        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function isPublicHoliday(): bool
    {
        return $this->isPublicHoliday;
    }

    public function setIsPublicHoliday(bool $isPublicHoliday): self
    {
        $this->isPublicHoliday = $isPublicHoliday;
        return $this;
    }

    public function getPublicHolidayName(): string
    {
        return $this->publicHolidayName;
    }

    public function setPublicHolidayName(?string $publicHolidayName): self
    {
        $this->publicHolidayName = $publicHolidayName;
        return $this;
    }

    public function isHoliday(): bool
    {
        return $this->isHoliday;
    }

    public function setIsHoliday(bool $isHoliday): self
    {
        $this->isHoliday = $isHoliday;
        return $this;
    }

    public function getHolidayName(): string
    {
        return $this->holidayName;
    }

    public function setHolidayName(?string $holidayName): self
    {
        $this->holidayName = $holidayName;
        return $this;
    }




}
