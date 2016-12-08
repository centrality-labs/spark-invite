<?php
namespace ZiNETHQ\SparkInvite\Facades;

use Illuminate\Support\Facades\Facade;

class SparkInvite extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sparkinvite';
    }
}
