<?php

namespace Francoisvaillant\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('calendar_bundle');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('holidays_url')
                    ->defaultValue('https://data.education.gouv.fr/api/explore/v2.1/catalog/datasets/fr-en-calendrier-scolaire/records?select=description,start_date,end_date,zones&limit=50&refine=start_date:"%%s"&refine=zones:"%%s"')
                ->end()
                ->scalarNode('public_holidays_url')
                    ->defaultValue('https://calendrier.api.gouv.fr/jours-feries/%%s/%%s.json')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
