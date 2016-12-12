<?php

namespace ZiNETHQ\SparkInvite;

use ZiNETHQ\SparkInvite\Models\Invitation;

class SparkInvite
{
    private $instance = null;

    public function invite($referralTeam, $referralUser, $invitee)
    {
        $invitation = new Invitation();
        $invitation->referralTeam()->associate($referralTeam);
        $invitation->referralUser()->associate($referralUser);
        $invitation->invitee()->associate($invitee);
        $invitation->token = str_random(40);
        $invitation->old_password = $invitee->password;
        $invitation->save();

        $this->publishEvent('invite', $invitation);

        return $invitation;
    }

    public function reinvite($invitation)
    {
        $invitation->cancel();
        $newInvitation = new Invitation();
        $newInvitation->referralTeam()->associate($this->referralTeam);
        $newInvitation->referralUser()->associate($this->referralUser);
        $newInvitation->invitee()->associate($this->invitee);
        $newInvitation->token = str_random(40);
        $newInvitation->old_password = $this->invitee->password;
        $newInvitation->save();

        $this->publishEvent('reissue', $newInvitation);

        return $newInvitation;
    }

    /**
     * Fire Laravel event
     * @param  string $event event name
     * @return self
     */
    private function publishEvent($event, $invitation = null)
    {
        Event::fire(config('sparkinvite.event.prefix').".{$event}", $invitation, false);
        return $this;
    }
}
