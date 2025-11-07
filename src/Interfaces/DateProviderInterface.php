<?php

namespace Francoisvaillant\CalendarBundle\Interfaces;

interface DateProviderInterface
{
    public function getDates(?int $year = null): array;

}
