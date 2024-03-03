<?php

namespace Iteks\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Enum extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'enum';
    }
}
