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
    private array $dayNames;
    private array $dates;
    private int $number;
    public function __construct()
    {
        $this->dayNames = DaysOfWeek::values();
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

    public function getDayNames(): array
    {
        return $this->dayNames;
    }


    // TODO make a separate class for this
    /**
     * @return array
     * @throws \Exception
     *
     *  1 => array:7 [
     *       "3" => array:8 [▶]
     *       "4" => array:8 [▶]
     *       "5" => array:8 [▶]
     *       "6" => array:8 [▶]
     *       "0" => array:8 [▶]
     *  ]
     *
     */
    public function build(): array
    {
        if(!$this->dates) {
            throw new \Exception('No dates provided. use setDates() to provide days');
        }

        $week = [];

        /** @var string $dayNameFr */
        foreach ($this->dayNames as $dayNameFr) {

            $dayOfWeek = DaysOfWeek::from(strtolower($dayNameFr));

            $value = array_filter(
                $this->dates,
                fn(Day $day) => ucfirst($day->getDayNameFr()) === ucfirst($dayNameFr)
            );

            $week[$dayOfWeek->code()] = !empty($value) ? reset($value) : null;
        }
        return $week;
    }


}
