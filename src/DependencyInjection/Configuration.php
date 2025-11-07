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
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('public_holidays_url')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
