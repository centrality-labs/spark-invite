<?php

namespace ZiNETHQ\SparkInvite\Listeners;

abstract class InvitationListener
{
    public function handle($event, $invitation)
    {
        return call_user_func($event, $invitation);
    }

    public abstract function pending($invitation);

    public abstract function issued($invitation);

    public abstract function successful($invitation);

    public abstract function revoked($invitation);

    public abstract function rejected($invitation);

    public abstract function expired($invitation);
}
