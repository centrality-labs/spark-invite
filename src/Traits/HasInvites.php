<?php

namespace ZiNETHQ\SparkInvite\Traits;

use ZiNETHQ\SparkInvite\Models\Invitation;
use Exception;

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
     * return successful invitation for this user
     * @return hasMany
     */
    public function wasInvited()
    {
        return $this->invitations()->count() > 0;
    }

    /**
     * return invitation for this user, by status
     * @return hasMany
     */
    public function invitationsByStatus($status)
    {
        if (!in_array($status, self::STATUS)) {
            throw new Exception("Status {$status} is not valid.");
        }

        return $this->invitations()->whereHas('status', function ($query) use ($status) {
            if (is_array($status)) {
                $query->whereIn('state', $status);
            } else {
                $query->where('state', $status);
            }
        });
    }
}
