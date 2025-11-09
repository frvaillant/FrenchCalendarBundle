<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Formattter;

class DateNameFormatter
{

    /**
     * @param \DateTime $date
     * @return string
     *
     * Return french Day name for a given date
     *
     */
    public static function format(\DateTime $date, string $locale = 'fr_FR', string $pattern = 'EEEE'): string
    {
        $formatter = new \IntlDateFormatter(
            $locale,
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            null,
            null,
            $pattern
        );

        return $formatter->format($date);

    }

}
