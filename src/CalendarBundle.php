<?php

namespace Francoisvaillant\CalendarBundle;

use Francoisvaillant\CalendarBundle\DependencyInjection\CalendarExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CalendarBundle extends Bundle
{
    public function getContainerExtension(): ?CalendarExtension
    {
        return new CalendarExtension();
    }
}
