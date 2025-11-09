<?php

namespace Francoisvaillant\CalendarBundle\Calendar;

use Francoisvaillant\CalendarBundle\Calendar\Representation\Day;
use Francoisvaillant\CalendarBundle\Enum\Region;
use Francoisvaillant\CalendarBundle\Enum\Zone;
use Francoisvaillant\CalendarBundle\Interfaces\CalendarInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CalendarProvider implements CalendarInterface
{

    public function __construct(
        private DatesProvider $datesProvider,
        private PublicHolidaysProvider $publicHolidaysProvider,
        private HolidaysProvider $holidaysProvider,
    )
    {
    }


    /**
     * @param Zone $zone
     * @param Region $region
     * @param int|null $year
     *
     * @return Calendar
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getCalendar(Zone $zone, Region $region = Region::METROPOLE, ?int $year = null): Calendar
    {

        $year = $year ?? (int)date('Y');

        /**
         * All dates of the year
         */
        $dates = $this->datesProvider->getDates($year);

        /**
         * Get french public holidays and french holidays
         */
        $publicHolidays = $this->publicHolidaysProvider->getPublicHolidays($region, $year);
        $holidays = $this->holidaysProvider->getFlattenHolidays($zone, $year);

        /**
         * Add holidays and public holidays informations in calendar dates
         */
        $this->addHolidaysInCalendar($dates, $publicHolidays, $holidays);

        $calendar = new Calendar();
        $calendar->setDates($dates);
        return $calendar;
    }

    /**
     * @param array $calendar
     * @param array $publicHolidays
     * @param array $holidays
     * @return void
     *
     * sets holidays and public holidays in calendar dates
     */
    private function addHolidaysInCalendar(array &$dates, array $publicHolidays, array $holidays): void
    {
        /**
         * @var int $weekNumber
         * @var Day[] $days
         *
         * Loop in a year
         */
        foreach ($dates as $weekNumber => &$days) {

            /**
             * @var  string $dateKey
             * @var Day $dayInfo
             *
             * loop in a week
             */
            foreach ($days as $dateKey => $dayInfo) {

                /** Check if date is a public holiday */
                if (isset($publicHolidays[$dateKey])) {
                    $dayInfo->setIsPublicHoliday(true);
                    $dayInfo->setPublicHolidayName($publicHolidays[$dateKey]['name']);
                }

                /** check if date is in holiday */
                if (isset($holidays[$dateKey])) {
                    $dayInfo->setIsHoliday(true);
                    $dayInfo->setHolidayName($holidays[$dateKey]);
                }
            }
            unset($dayInfo);
        }
        unset($days);
    }


}
