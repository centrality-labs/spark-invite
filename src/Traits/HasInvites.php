<?php

namespace CentralityLabs\SparkInvite\Traits;

use CentralityLabs\SparkInvite\Models\Invitation;
use CentralityLabs\SparkInvite\SparkInvite;
use Exception;

trait HasInvites
{
    /**
     * return successful invitation for this user
     * @return hasMany
     */
    public function wasInvited()
    {
        return $this->sparkInvites()->count() > 0;
    }

    /**
     * return all invitation as a Laravel collection
     * @return hasMany invitation Models
     */
    public function sparkInvites()
    {
        return $this->hasMany(SparkInvite::invitationModel());
    }

    /**
     * return invitation for this user, by status
     * @return hasMany
     */
    public function sparkInvitesByStatus($status)
    {
        if (!in_array($status, self::STATUS)) {
            throw new Exception("Status {$status} is not valid.");
        }

        return $this->sparkInvites()->whereHas('status', function ($query) use ($status) {
            if (is_array($status)) {
                $query->whereIn('state', $status);
            } else {
                $query->where('state', $status);
            }
        });
    }

    /**
     * return invitation for this user, by status
     * @return hasMany
     */
    public function sparkInvitesByExcludedStatus($status)
    {
        if (!in_array($status, self::STATUS)) {
            throw new Exception("Status {$status} is not valid.");
        }

        return $this->sparkInvites()->whereDoesntHave('status', function ($query) use ($status) {
            if (is_array($status)) {
                $query->whereIn('state', $status);
            } else {
                $query->where('state', $status);
            }
        });
    }
}
