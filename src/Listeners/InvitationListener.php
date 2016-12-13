<?php

namespace ZiNETHQ\SparkInvite\Listeners;

abstract class InvitationListener
{
    public function handle($event, $invitation)
    {
        return call_user_func(array($this, $event), $invitation);
    }

    abstract public function invite($invitation);

    abstract public function reinvite($invitation);

    abstract public function pending($invitation);

    abstract public function issued($invitation);

    abstract public function accepted($invitation);

    abstract public function successful($invitation);

    abstract public function revoked($invitation);

    abstract public function rejected($invitation);

    abstract public function expired($invitation);
}
