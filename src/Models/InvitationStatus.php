<?php

namespace ZiNETHQ\SparkInvite\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Spark\Spark;
use ZiNETHQ\SparkInvite\Models\Invitation;

class InvitationStatus extends Model
{
    public $timestamps = true;
    protected $table = 'invitation_status';

    public static function make($invitation, $state, $auditTeam = null, $auditUser = null, $notes = null)
    {
        $status = new InvitationStatus();
        $status->state = $state;
        $status->invitation()->associate($invitation);
        $status->auditTeam()->associate($auditTeam);
        $status->auditUser()->associate($auditUser);
        $status->notes = $notes;
        $status->save();
        return $status;
    }

    /**
     * Invitation
     */
    public function invitation()
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    /**
     * Audit Team
     */
    public function auditTeam()
    {
        return $this->belongsTo(Spark::teamModel(), 'audit_team_id');
    }

    /**
     * Audit User
     */
    public function auditUser()
    {
        return $this->belongsTo(Spark::userModel(), 'audit_user_id');
    }
}
