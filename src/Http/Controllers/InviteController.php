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

        if (!$invitation) {
            return redirect('/')
                ->with($this->getMessage('invalid-token'));
        }

        if ($invitation->isRevoked()) {
            return redirect('/')
                ->with($this->getMessage('revoked'));
        }

        if ($invitation->isRejected()) {
            return redirect('/')
                ->with($this->getMessage('rejected'));
        }

        if ($invitation->isExpired()) {
            if (config('sparkinvite.reissue-on-expiry')) {
                SparkInvite::reissue($invitation);
            }
            return redirect('/')
                ->with($this->getMessage('expired'));
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

        if ($invitation) {
            $invitation->reject();
        }

        return redirect('/')
                ->with($this->getMessage('rejected'));
    }

    private function getMessage($key)
    {
        return [
            config('sparkinvite.flash') => collect([
                config('sparkinvite.messages.{$key}')
            ])
        ];
    }
}
