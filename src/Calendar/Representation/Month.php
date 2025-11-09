<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Representation;

final class Month
{
    public function __construct(
        public int $year,
        public int $month
    ) {}

    /**
     * @return \DateTime
     * @throws \Exception
     *
     * Returns the first day of the month
     */
    public function toDateTime(): \DateTime
    {
        return new \DateTime(sprintf('%04d-%02d-01', $this->year, $this->month));
    }


    /**
     * @param string $locale
     *
     * @return string
     *
     * @throws \Exception
     *
     * Returns the month name in the given locale. Default locale is fr_FR
     */
    public function localName(string $locale = 'fr_FR'): string
    {
        $formatter = new \IntlDateFormatter($locale, \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, null, null, 'MMMM');
        return ucfirst($formatter->format($this->toDateTime()));
    }

    public function name(string $locale = 'fr_FR'): string
    {
        return $this->toDateTime()->format('F');
    }

    public function __toString(): string
    {
        return sprintf('%s %d', $this->frenchName(), $this->year);
    }
}

