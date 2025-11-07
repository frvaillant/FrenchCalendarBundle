<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Representation;

use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;

/**
 *
 * This class generates a representative array for a week
 *
 * 1 => array:7 [
 *      "Mercredi" => array:8 [▶]
 *      "Jeudi" => array:8 [▶]
 *      "Vendredi" => array:8 [▶]
 *      "Samedi" => array:8 [▶]
 *      "Dimanche" => array:8 [▶]
 * ]
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


    /**
     * @return array
     * @throws \Exception
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
