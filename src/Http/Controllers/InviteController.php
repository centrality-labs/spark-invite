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
     * Consume an invitation.
     *
     * @return Response
     */
    public function consume(Request $request, $token)
    {
        $invitation = Invitation::get($token);

        if (!$invitation) {
            return redirect('/')
                ->with($this->getMessage('invalid-token'));
        }

        if ($invitation->isCancelled()) {
            return redirect('/')
                ->with($this->getMessage('cancelled'));
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

        // $token = $invitation->accept();
        // return redirect("/password/reset/{$token}")->with('email', $invitation->invitee->email);
        return redirect()->route('password.reset', [
            'token' => $invitation->accept(),
            'email' => $invitation->invitee->email
        ]);
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
