<?php

namespace ZiNETHQ\SparkInvite\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZiNETHQ\SparkInvite\SparkInvite;
use ZiNETHQ\SparkInvite\Models\Invitation;
use Auth;

class InviteController extends Controller
{
    /**
     * Accept an invitation.
     *
     * @return Response
     */
    public function accept(Request $request, $token)
    {
        $invitation = Invitation::get($token);
        $err = config('sparkinvite.routes.on-error');

        if (!$invitation) {
            return redirect($err)
                ->with($this->getMessage('error', 'invalid-token'));
        }

        if ($invitation->isPending()) {
            return redirect($err)
                ->with($this->getMessage('info', 'pending'));
        }

        if ($invitation->isRevoked()) {
            return redirect($err)
                ->with($this->getMessage('warning', 'revoked'));
        }

        if ($invitation->isRejected()) {
            return redirect($err)
                ->with($this->getMessage('info', 'rejected'));
        }

        if ($invitation->isExpired()) {
            if (config('sparkinvite.reissue-on-expiry')) {
                SparkInvite::reissue($invitation);
            }
            return redirect($err)
                ->with($this->getMessage('info', 'expired'));
        }

        // Ensure logged out otherwise this wont work...
        Auth::logout();

        return redirect()->route('password.reset', [
            'token' => $invitation->accept(),
            'email' => $invitation->invitee->email
        ]);
    }

    /**
     * Reject an invitation.
     *
     * @return Response
     */
    public function reject(Request $request, $token)
    {
        $invitation = Invitation::get($token);
        $err = config('sparkinvite.routes.on-error');

        if ($invitation) {
            $invitation->reject();
        }

        return redirect($err)
                ->with($this->getMessage('info', 'rejected'));
    }

    private function getMessage($type, $key)
    {
        return [
            config('sparkinvite.flash') => [
                'type' => $type,
                'content' => config('sparkinvite.messages.{$key}')
            ]
        ];
    }
}
