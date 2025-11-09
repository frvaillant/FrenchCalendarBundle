<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Builder;

use Francoisvaillant\CalendarBundle\Calendar\Representation\Day;
use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;

class WeekBuilder
{

    private array $dates;

    public function setDates(array $dates): void
    {
        $this->dates = $dates;
    }

    public function getDates(): array
    {
        return $this->dates;
    }

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
    public function buildAsArray(): array
    {
        if(!$this->dates) {
            throw new \Exception('No dates provided. use setDates() to provide days');
        }

        $week = [];

        /** @var string $dayNameFr */
        foreach (DaysOfWeek::values() as $dayNameFr) {
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
