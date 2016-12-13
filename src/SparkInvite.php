<?php

namespace ZiNETHQ\SparkInvite;

use ZiNETHQ\SparkInvite\Models\Invitation;
use Webpatser\Uuid\Uuid as Uuid;
use Event;

class SparkInvite
{
    public function invite($referralTeam, $referralUser, $invitee, $event = 'invite')
    {
        $invitations = Invitation::getByInvitee($invitee);
        if ($invitations->count() > 0) {
            $invitation = $invitations->first();
            $invitation->validate();
            return $invitation;
        }

        $invitation = Invitation::make($referralTeam, $referralUser, $invitee);

        $this->publishEvent($event, $invitation);

        return $invitation;
    }

    public function reinvite($invitation, $auditTeam = null, $auditUser = null, $notes = null)
    {
        $invitation->revoke($auditTeam, $auditUser, $notes);
        return $this->invite($invitation->referralTeam, $invitation->referralUser, $invitation->invitee, 'reinvite');
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
