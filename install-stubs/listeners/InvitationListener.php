<?php

namespace App\Listeners;

use ZiNETHQ\SparkInvite\Listeners\InvitationListener as Listener;

class InvitationListener extends Listener
{
    public function pending($invitation)
    {
        return;
    }

    public function issued($invitation)
    {
        return;
    }

    public function successful($invitation)
    {
        return;
    }

    public function revoked($invitation)
    {
        return;
    }

    public function rejected($invitation)
    {
        return;
    }

    public function expired($invitation)
    {
        return;
    }
}
