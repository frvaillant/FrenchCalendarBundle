<?php

namespace Francoisvaillant\CalendarBundle;

use Francoisvaillant\CalendarBundle\DependencyInjection\CalendarExtension;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CalendarBundle extends AbstractBundle
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
