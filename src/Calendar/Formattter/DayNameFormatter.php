<?php

namespace Francoisvaillant\CalendarBundle\Calendar\Formattter;

class DayNameFormatter
{

    /**
     * @param \DateTime $date
     * @return string
     *
     * Return french Day name for a given date
     *
     */
    public static function format(\DateTime $date): string
    {
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            'Europe/Paris',
            \IntlDateFormatter::GREGORIAN,
            'EEEE'
        );

        return $formatter->format($date);

    }

}
