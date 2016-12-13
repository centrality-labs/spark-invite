<?php

namespace ZiNETHQ\SparkInvite;

use ZiNETHQ\SparkInvite\Models\Invitation;
use Event;

class SparkInvite
{
    public function invite($referrerTeam, $referrer, $invitee, $event = 'invite')
    {
        $invitations = Invitation::getByInvitee($invitee);
        if ($invitations->count() > 0) {
            $invitation = $invitations->first();
            $invitation->validate();
            return $invitation;
        }

        $invitation = Invitation::make($referrerTeam, $referrer, $invitee);

        $this->publishEvent($event, $invitation);

        return $invitation;
    }

    public function reinvite($invitation, $team = null, $user = null, $notes = null)
    {
        $invitation->revoke($team, $user, $notes);
        return $this->invite($invitation->referrerTeam, $invitation->referrer, $invitation->invitee, 'reinvite');
    }

    /**
     * Fire Laravel event
     * @param  string $event event name
     */
    private function publishEvent($eventKey, $invitation = null)
    {
        Event::fire(config('sparkinvite.event.prefix').".{$eventKey}", [
            'event' => $eventKey,
            'invitation' => $invitation
        ], false);
    }
}
