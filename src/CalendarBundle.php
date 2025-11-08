<?php

namespace Francoisvaillant\CalendarBundle;

use Francoisvaillant\CalendarBundle\DependencyInjection\CalendarExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CalendarBundle extends Bundle
{
    public function getContainerExtension(): ?CalendarExtension
    {
        return new CalendarExtension();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
