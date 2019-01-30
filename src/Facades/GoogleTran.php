<?php

namespace  GoogleTran\Translate\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleTran extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'googletranslate';
    }
}