<?php

namespace  GTran\Translate\Facades;

use Illuminate\Support\Facades\Facade;

class GTran extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gtran';
    }
}