<?php

namespace Francoisvaillant\CalendarBundle\Calendar;

use Francoisvaillant\CalendarBundle\Calendar\Builder\WeekBuilder;
use Francoisvaillant\CalendarBundle\Calendar\Representation\Day;
use Francoisvaillant\CalendarBundle\Calendar\Representation\Month;
use Francoisvaillant\CalendarBundle\Calendar\Representation\Week;
use Francoisvaillant\CalendarBundle\Enum\DaysOfWeek;
use Francoisvaillant\CalendarBundle\Enum\MonthsOfYear;

class Calendar
{

    private ?array $dates = null;

    private string $format = self::AS_WEEKS;

    const AS_DAYS = 'days';
    const AS_WEEKS  = 'weeks';
    const AS_MONTHS = 'months';

    public function setDates(array $dates): void
    {
        $this->dates = $dates;
    }

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    private function formatAsWeeks(?int $chosenWeek = null): array
    {
        if(!$this->dates) {
            throw new \Exception('No dates provided. use setDates() to provide dates');
        }

        $calendar = [];

        $weekBuilder = new WeekBuilder();

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
            $weekBuilder->setDates($dates);
            $calendar[$week->getNumber()] = $weekBuilder->buildAsArray();
        }

        if ($chosenWeek && isset($calendar[$chosenWeek])) {
            return [$chosenWeek => $calendar[$chosenWeek]];
        }

        return $calendar;
    }

    /**
     * @param int|null $chosenMonth
     *
     * @return array|array[]
     *
     * @throws \Exception
     */
    private function formatAsMonth(?int $chosenMonth = null): array
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

                $MONTH = new Month((int)$date->format('Y'), $monthNumber);

                if (!isset($months[$monthNumber])) {
                    $months[$monthNumber] = [
                        'month' => $MONTH,
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

        if ($chosenMonth && isset($months[$chosenMonth])) {
            return [$chosenMonth => $months[$chosenMonth]];
        }

        return $months;

    }

    /**
     * @param int|null $chosenPeriod // i.e month or week number. e.g. 1 for january if you chose format AS_MONTHS
     *
     * @return array|array[]
     *
     * @throws \Exception
     */
    public function getCalendar(?int $chosenPeriod = null): array
    {
        return match ($this->format) {
            self::AS_DAYS => $this->dates,
            self::AS_WEEKS => $this->formatAsWeeks($chosenPeriod),
            self::AS_MONTHS => $this->formatAsMonth($chosenPeriod),
            default => throw new \Exception('Invalid format'),
        };
    }

}
