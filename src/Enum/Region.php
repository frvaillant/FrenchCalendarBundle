<?php

/**
 * source : https://www.data.gouv.fr/dataservices/jours-feries/
 */

namespace Francoisvaillant\CalendarBundle\Enum;

enum Region: string
{
    case ALSACE_MOSELLE = 'alsace-moselle';
    case GUADELOUPE = 'guadeloupe';
    case GUYANE = 'guyane';
    case LA_REUNION = 'la-reunion';
    case MARTINIQUE = 'martinique';
    case MAYOTTE = 'mayotte';
    case METROPOLE = 'metropole';
    case NOUVELLE_CALEDONIE = 'nouvelle-caledonie';
    case POLYNESIE_FRANCAISE = 'polynesie-francaise';
    case SAINT_BARTHELEMY = 'saint-barthelemy';
    case SAINT_MARTIN = 'saint-martin';
    case SAINT_PIERRE_ET_MIQUELEON = 'saint-pierre-et-miquelon';
    case WALLIS_ET_FUTUNA = 'wallis-et-futuna';

    public static function values(): array
    {
        return array_map(fn(self $region) => $region->value, self::cases());
    }
}
