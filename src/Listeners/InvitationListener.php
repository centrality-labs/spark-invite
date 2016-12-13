<?php

namespace ZiNETHQ\SparkInvite\Listeners;

abstract class InvitationListener
{
    public function handle($event, $invitation)
    {
        return call_user_func($event, $invitation);
    }
}
