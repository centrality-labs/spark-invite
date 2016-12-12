<?php

namespace ZiNETHQ\SparkInvite\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZiNETHQ\SparkInvite\Invitation;

use SparkInvite;

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

        $token = $invitation->accept();

        // return redirect("/password/reset/{$token}");
        // Route name is password.reset

        return view('spark::auth.passwords.reset')
                ->with(['token' => $token, 'email' => $invitation->invitee->email]);
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
