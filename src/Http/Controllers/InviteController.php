<?php

namespace ZiNETHQ\SparkInvite\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZiNETHQ\SparkInvite\Invitation;

class InviteController extends Controller
{
    /**
     * Consume an invitation.
     *
     * @return Response
     */
    public function consume(Request $request, $code)
    {
        $invitation = Invitation::byCode($code);

        if (!$invitation) {
            return redirect('/')->with('status', 'Not a valid invitation!');
        }

        if (!$invitation->isPending()) {
            return redirect('/')->with('status', 'Invitation it not valid!');
        }

        $token;

        return redirect("/password/reset/{$token}");
    }
}
