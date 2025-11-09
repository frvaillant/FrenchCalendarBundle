<?php

namespace Francoisvaillant\CalendarBundle\Calendar;

use DateTime;
use Francoisvaillant\CalendarBundle\Enum\Zone;
use Francoisvaillant\CalendarBundle\Interfaces\HolidaysProviderInterface;
use Symfony\Component\HttpClient\HttpClient;

class HolidaysProvider implements HolidaysProviderInterface
{
    public function __construct(private string $holidaysUrl)
    {
    }

    /**
     * @param Zone $zone
     * @param int|null $year
     *
     * @return array
     *
     * @throws \Exception
     *
     * Returns an array of holidays for the given year and zone
     *
     * "Vacances d'Hiver" => array:6 [
     *      "description" => "Vacances d'Hiver"
     *      "start_date" => "2025-02-22T23:00:00+00:00"
     *      "end_date" => "2025-03-09T23:00:00+00:00"
     *      "zones" => "Zone A"
     *      "start_key" => "20250222"
     *      "end_key" => "20250309"
     * ]
     * "Vacances de Printemps" => array []
     * ...
     */
    public function getHolidays(Zone $zone, ?int $year = null): array
    {
        $year = $year ?? (int)date('Y');
        $holidays = $this->fetchHolidaysApi($year, $zone);
        return $this->buildHolidays($holidays);
    }


    /**
     * @param Zone $zone
     * @param int|null $year
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     *
     * returns an array of holidays flattened :
     * 20250307 => "Vacances d'Hiver"
     * 20250308 => "Vacances d'Hiver"
     * 20250309 => "Vacances d'Hiver"
     * 20250419 => "Vacances de Printemps"
     * 20250420 => "Vacances de Printemps"
     * 20250421 => "Vacances de Printemps"
     *
     */
    public function getFlattenHolidays(Zone $zone, ?int $year = null): array
    {
        $year = $year ?? (int)date('Y');
        $holidays = $this->fetchHolidaysApi($year, $zone);

        $holidays = $this->buildHolidays($holidays);

        return $this->flattenHolidays($holidays);
    }

    /**
     * @param $year
     * @param $zone
     *
     * @return array|null
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     *
     * Fetches holidays from the API
     */
    protected function fetchHolidaysApi($year, $zone): ?array
    {
        $url = sprintf($this->holidaysUrl, $year, $zone->value);
        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception(sprintf('Error while fetching holidays API for year %s on %s', $year, $url), $response->getStatusCode());
        }

        $holidays = $response->toArray()['results'] ?? [];

        $pastYear = $year - 1;
        $christmasUrl = sprintf($this->holidaysUrl, $pastYear, $zone->value) . '&refine=description:"Vacances de Noël"';
        $r = $client->request('GET', $christmasUrl);
        $christmasHolidays = $r->toArray()['results'] ?? [];
        $christmasHolidays[0]['description'] = 'Vacances de Noël ' . $pastYear . ' - ' . $year;

        return [$christmasHolidays[0], ...$holidays];
    }

    /**
     * @param array|null $holidays
     * @return array
     * @throws \Exception
     *
     * Builds the holidays array :
     * "Vacances d'Hiver" => [
     *      "description" => "Vacances d'Hiver"
     *      "start_date" => "2025-02-22T23:00:00+00:00"
     *      "end_date" => "2025-03-09T23:00:00+00:00"
     *      "zones" => "Zone A"
     *      "start_key" => "20250222"
     *      "end_key" => "20250309"
     * ]
     * ...
     */
    private function buildHolidays(?array $holidays): array
    {
        if(!$holidays) {
            return [];
        }

        $uniqueHolidays = [];

        foreach ($holidays as $holiday) {

            if(!isset($holiday['start_date'])) {
                continue;
            }

            $desc = $holiday['description'];
            if (!isset($uniqueHolidays[$desc])) {

                $start = new DateTime($holiday['start_date']);

                /**
                 * API returns the last school day before holidays. Holidays really begin on the next day.
                 */
                $start->modify('+1 day');

                $holiday['start_date'] = $start->format(\DateTime::ATOM);
                $holiday['start_key'] = $start->format('Ymd');

                $end = new DateTime($holiday['end_date']);
                $holiday['end_key'] = $end->format('Ymd');

                $uniqueHolidays[$desc] = $holiday;
            }
        }
        return $uniqueHolidays;
    }

    /**
     * @param array $holidays
     * @return array
     *
     * Returns an array of holidays flattened :
     * "20251222" => "Vacances d'Hiver"
     * "20251223" => "Vacances d'Hiver"
     */
    private function flattenHolidays(array $holidays): array
    {
        $days = [];

        foreach ($holidays as $holiday) {
            $start = \DateTime::createFromFormat('Ymd', $holiday['start_key']);
            $end   = \DateTime::createFromFormat('Ymd', $holiday['end_key']);

            while ($start <= $end) {
                $key = $start->format('Ymd');
                $days[$key] = $holiday['description'];
                $start->modify('+1 day');
            }
        }
        ksort($days);
        return $days;
    }
}
