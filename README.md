# CalendarBundle

Ce bundle génère un calendrier complet incluant les jours fériés et les vacances scolaires françaises.

Il peut également générer un tableau organisé par mois.

## Requirements
symfony >=6.4 
php >=8.1

## Installation

composer require francoisvaillant/calendar-bundle

## Utilisation

```PHP 
    use Francoisvaillant\CalendarBundle\Calendar\CalendarProvider;
    use Francoisvaillant\CalendarBundle\Enum\Zone;
    use Francoisvaillant\CalendarBundle\Enum\Region;

    // Calendrier de l'année en cours
    // Vous avez juste à spécifier la zone pour les vacances scolaires
    // Les jours fériés sont générés par défaut pour la métropole
    $calendar = $calendarProvider->getCalendar(Zone::ZONE_A).
    
    // Pour une autre région, zone, année : 
    $calendar = $calendar = $calendarProvider->getCalendar(zone: Zone::NOUVELLE_CALEDONIE, year: 2024, region: Region::NOUVELLE_CALEDONIE);
```

Vous obtenez un tableau de jours regroupés par numéro de semaine :  
```PHP
1 => array:8 [▼
    20250101 => array:8 [▼
      "date" => DateTime @1735689600 {#141 …1}
      "day_name" => "Wednesday"
      "day_name_fr" => "mercredi"
      "day_number" => "3"
      "is_public_holiday" => true
      "public_holiday_name" => "1er janvier"
      "is_holiday" => true
      "holiday_name" => "Vacances de Noël 2024"
    ]
    20250102 => array:8 [▼
      "date" => DateTime @1735776000 {#142 …1}
      "day_name" => "Thursday"
      "day_name_fr" => "jeudi"
      "day_number" => "4"
      "is_public_holiday" => false
      "public_holiday_name" => null
      "is_holiday" => true
      "holiday_name" => "Vacances de Noël 2024"
    ]
```


# Docs
https://data.education.gouv.fr/explore/dataset/fr-en-calendrier-scolaire/api/?disjunctive.description&disjunctive.location&disjunctive.zones&disjunctive.annee_scolaire&disjunctive.population&refine.zones=Zone+A&refine.description=Vacances+de+No%C3%ABl&refine.start_date=2024  
https://www.data.gouv.fr/dataservices/jours-feries/
