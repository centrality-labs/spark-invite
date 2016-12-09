<?php
namespace ZiNETHQ\SparkInvite\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Spark\Spark;
use Carbon\Carbon;
use Log;

class Invitation extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESSFUL =  'successful';
    const STATUS_CANCELLED = 'canceled';
    const STATUS_EXPIRED = 'expired';
    const STATUS = [ STATUS_PENDING, STATUS_SUCCESSFUL, STATUS_CANCELLED, STATUS_EXPIRED ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_invitations';

    public static function byCode($code)
    {
        return self::where('code', $code)->first();
    }

    /**
     * Referral User
     */
    public function referralUser()
    {
        return $this->belongsTo(Spark::userModel(), 'referral_user_id');
    }

    /**
     * Referral Team
     */
    public function referralTeam()
    {
        return $this->belongsTo(Spark::teamModel(), 'referral_team_id');
    }

    /**
     * Invitee
     */
    public function invitee()
    {
        return $this->belongsTo(Spark::userModel(), 'invitee_id');
    }

    public function validate($email)
    {
        return strtolower($this->invitee()->email) === strtolower($email);
    }

    public function cancel()
    {
        if ($this->isExpired()) {
            return false;
        }

        if (!$this->isPending()) {
            Log::warning("Attempted to cancel an invitation for user {$this->invitee_id} that has the {$this->status} status.");
            return false;
        }

        $this->status = self::STATUS_CANCEL;
        $this->save();

        return true;
    }

    public function accept()
    {
        if ($this->isExpired()) {
            return false;
        }

        if (!$this->isPending()) {
            Log::warning("Attempted to accept an invitation for user {$this->invitee_id} that has the {$this->status} status.");
            return false;
        }

        Auth::guard()->login($this->invitee());
        $this->status = self::STATUS_SUCCESSFUL;
        $this->save();

        return true;
    }

    /*
    |----------------------------------------------------------------------
    | Magic Methods
    |----------------------------------------------------------------------
    */
    /**
     * Magic __call method to handle dynamic methods.
     *
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($method, $arguments = array())
    {
        // Handle isStatus() methods
        if (starts_with($method, 'is') && $method !== 'is' && $method !== 'isStatus') {
            $status = strtolower(substr($method, 2));

            return $this->isStatus($status);
        }

        return parent::__call($method, $arguments);
    }

    /*
    |----------------------------------------------------------------------
    | Private Methods
    |----------------------------------------------------------------------
    */
    private function isStatus($status)
    {
        if ($this->status === $status) {
            return true;
        }

        if ($this->status === self::STATUS_PENDING && Carbon::now()->diffInHours($this->created_at) >= config('sparkinvite.expires')) {
            $this->status = self::STATUS_EXPIRED;
            $this->save();
            return $status === self::STATUS_EXPIRED;
        }

        return false;
    }
}
