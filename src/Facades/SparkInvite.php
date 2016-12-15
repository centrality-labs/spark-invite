<?php
namespace ZiNETHQ\SparkInvite\Facades;

use Illuminate\Support\Facades\Facade;
use ZiNETHQ\SparkInvite\SparkInvite as Invite;

class SparkInvite extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Invite::class;
    }
}
