<?php

namespace Francoisvaillant\CalendarBundle\Calendar;

use Francoisvaillant\CalendarBundle\Calendar\Representation\Day;
use Francoisvaillant\CalendarBundle\Calendar\Representation\Week;
use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;
use Francoisvaillant\CalendarBundle\Enum\MonthsOfYear;

class Calendar
{

    private ?array $dates = null;

    public function getDates(): array
    {
        return $this->dates;
    }

    public function setDates(array $dates): void
    {
        $this->dates = $dates;
    }

    public function formatAsWeeks(): array
    {
        if(!$this->dates) {
            throw new \Exception('No dates provided. use setDates() to provide dates');
        }

        $calendar = [];

        /**
         * @var int $weekNumber
         * @var array $dates
         */
        foreach ($this->dates as $weekNumber => $dates) {
            $week = new Week();
            $week
                ->setNumber($weekNumber)
                ->setDates($dates)
            ;
            $calendar[$week->getNumber()] = $week->build();
        }

        return $calendar;
    }


    public function formatAsMonths(?int $chosenMonth = null): array
    {
        if(!$this->dates) {
            throw new \Exception('No dates provided. use setDates() to provide dates');
        }


        $weeks = $this->formatAsWeeks();
        $months = [];

        foreach ($weeks as $weekNumber => $weekDays) {
            /**
             * @var int $dayCode
             * @var Day $dayInfo
             */
            foreach ($weekDays as $dayCode => $dayInfo) {
                if ($dayInfo === null) {
                    continue;
                }

                /** @var \DateTime $date */
                $date = $dayInfo->getDate();
                $monthNumber = (int)$date->format('n');

                $monthEnum = MonthsOfYear::cases()[$monthNumber - 1] ?? null;

                if ($monthEnum === null) {
                    continue;
                }

                if (!isset($months[$monthNumber])) {
                    $months[$monthNumber] = [
                        'name' => $monthEnum->value,
                        'weeks' => [],
                    ];
                }

                // Initialise la semaine dans le mois
                if (!isset($months[$monthNumber]['weeks'][$weekNumber])) {
                    $months[$monthNumber]['weeks'][$weekNumber] = array_fill_keys(DaysOfWeek::codes(), null);
                }

                $months[$monthNumber]['weeks'][$weekNumber][$dayCode] = $dayInfo;
            }
        }

        if ($chosenMonth) {
            return [$chosenMonth => $months[$chosenMonth]];
        }

        return $months;

    }




}
