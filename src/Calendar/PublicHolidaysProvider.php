<?php

namespace Francoisvaillant\CalendarBundle\Calendar;

use Francoisvaillant\CalendarBundle\Enum\Region;
use Francoisvaillant\CalendarBundle\Interfaces\PublicHolidaysProviderInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PublicHolidaysProvider implements PublicHolidaysProviderInterface
{
    public function __construct(private readonly string $publicHolidaysUrl)
    {

    }

    /**
     * @param Region $region
     * @param int|null $year
     *
     * @return array
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getPublicHolidays(Region $region = Region::METROPOLE, ?int $year = null): array
    {
        $year = $year ?? (int)date('Y');

        $publicHolidays = $this->fetchPublicHolidaysApi($year, $region);
        return $this->formatPublicHolidaysData($publicHolidays);
    }

    /**
     * @param int $year
     * @param Region $region
     *
     * @return array
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * Fetch public holidays from API
     * https://www.data.gouv.fr/dataservices/jours-feries/(url is set in config yaml file)
     *
     * Returned data should look like this :
     * {
     * "2027-01-01": "1er janvier",
     * "2027-03-29": "Lundi de Pâques",
     * ...
     * }
     */
    protected function fetchPublicHolidaysApi(int $year, Region $region): array
    {
        $client = HttpClient::create();
        $url = sprintf($this->publicHolidaysUrl, $region->value, $year);
        $response = $client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception(sprintf('Error while fetching public holidays API for year %s on %s', $year, $url), $response->getStatusCode());
        }

        return $response->toArray();
    }

    /**
     * @param array $publicHolidays
     *
     * @return array
     *
     * Format the public holidays data to be used in the calendar :
     * "2027-01-01" => "1er janvier"
     *  becomes
     * "20270101" => [
     *  "name" => "1er janvier"
     *  "date" => "2027-01-01"
     * ]
     */
    private function formatPublicHolidaysData(array $publicHolidays): array
    {
        return array_combine(
            array_map(fn($date) => str_replace('-', '', $date), array_keys($publicHolidays)),
            array_map(fn($name, $date) => ['name' => $name, 'date' => $date], $publicHolidays, array_keys($publicHolidays))
        );
    }




}
