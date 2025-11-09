<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Representation;

use Francoisvaillant\CalendarBundle\Calendar\Formattter\DateNameFormatter;

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
     * Returns the month name in the given locale. The default locale is fr_FR
     */
    public function localName(string $locale = 'fr_FR'): string
    {
        return ucfirst(DateNameFormatter::format($this->toDateTime(), $locale, 'MMMM'));
    }

    /**
     * @return string
     *
     * @throws \Exception
     *
     * returns the month name in English
     */
    public function name(): string
    {
        return $this->toDateTime()->format('F');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s %d', $this->frenchName(), $this->year);
    }
}

