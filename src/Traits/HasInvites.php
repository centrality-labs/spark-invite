<?php

namespace ZiNETHQ\SparkInvite\Traits;

use ZiNETHQ\SparkInvite\Models\Invitation;

trait HasInvites
{
    /**
     * return all invitation as a Laravel collection
     * @return hasMany invitation Models
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * return invitation by a user, by type
     * @return hasMany
     */
    public function invitationsByStatus($status)
    {
        return $this->invitations()->where('status', $status);
    }

    /**
     * return successful invitation by a user
     * @return hasMany
     */
    public function invitationSuccess()
    {
        return $this->invitations()->where('status', Invitation::STATUS_SUCCESSFUL);
    }

    /**
     * return expired invitations by a user
     * @return hasMany
     */
    public function invitationExpired()
    {
        return $this->invitations()->where('status', Invitation::STATUS_EXPIRED);
    }

    /**
     * return cancelled invitations by a user
     * @return hasMany
     */
    public function invitationCancelled()
    {
        return $this->invitations()->where('status', Invitation::STATUS_CANCELLED);
    }

    /**
     * return pending invitations by a user
     * @return hasMany
     */
    public function invitationPending()
    {
        return $this->invitations()->where('status', Invitation::STATUS_PENDING);
    }
}
