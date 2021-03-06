<?php

namespace Connectum\Ronin\Facades;

use Illuminate\Support\Facades\Facade;

class Ronin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ronin';
    }
}
