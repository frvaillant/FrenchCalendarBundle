<?php
namespace Francoisvaillant\CalendarBundle\Calendar;

use DateTime;
use Francoisvaillant\CalendarBundle\Calendar\Formattter\DayNameFormatter;
use Francoisvaillant\CalendarBundle\Calendar\Representation\Day;
use Francoisvaillant\CalendarBundle\Interfaces\DateProviderInterface;

class DatesProvider implements DateProviderInterface
{

    public function __construct()
    {

    }


    /**
     * @return array
     *
     * Returns all the dates of the given year (default: current year) grouped by week number
     *
     * Example :
     * [
     *  '1' => [
     *      '20220101' => [
     *          'date' => '2025-01-01',
     *          'date_fr' => '01-01-2025',
     *          'day_name' => 'Monday',
     *          'day_name_fr' => 'Lundi',
     *          'day_number' => 1,
     *          'is_public_holiday' => false,
     *          'public_holiday_name' => null,
     *          'is_holiday' => false,
     *      ],
     *      '20220102' => []
     ]
     ]
     */
    public function getDates(?int $year = null): array
    {
        $year = $year ?? (int)date('Y');

        $weekNumber = 1;
        $dates = [];

        $start = new \DateTime("$year-01-01");
        $end   = new \DateTime("$year-12-31");

        while ($start <= $end) {
            $key = $start->format('Ymd');

            if((int)$start->format('w') === 1) {
                $weekNumber++;
            }

            $day = new Day();
            $day
                ->setDate(clone $start)
                ->setDayName($start->format('l'))
                ->setDayNameFr(DayNameFormatter::format($start))
                ->setDayNumber((int)$start->format('w'))
                ->setWeekNumber($weekNumber)
                ->setIsPublicHoliday(false)
                ->setPublicHolidayName(null)
                ->setIsHoliday(false)
                ->setHolidayName(null)
                ;

            $dates[$weekNumber][$key] = $day;

            $start->modify('+1 day');
        }

        return $dates;
    }
}
