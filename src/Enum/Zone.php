<?php

namespace Francoisvaillant\CalendarBundle\Enum;

enum Zone: string
{
    case CORSE = 'Corse';
    case GUADELOUPE = 'Guadeloupe';
    case GUYANE = 'Guyane';
    case MARTINIQUE = 'Martinique';
    case MAYOTTE = 'Mayotte';
    case NOUVELLE_CALEDONIE = 'Nouvelle Calédonie';
    case POLYNESIE = 'Polynésie';
    case REUNION = 'Réunion';
    case SAINT_PIERRE_ET_MIQUELON = 'Saint Pierre et Miquelon';
    case WALLIS_ET_FUTUNA = 'Wallis et Futuna';
    case ZONE_A = 'Zone A';
    case ZONE_B = 'Zone B';
    case ZONE_C = 'Zone C';


    public static function values(): array
    {
        return array_map(fn(self $zone) => $zone->value, self::cases());
    }
}
