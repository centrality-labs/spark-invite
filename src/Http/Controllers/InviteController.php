<?php

namespace SparkInvite\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    /**
     * Get the all of the regular plans defined for the application.
     *
     * @return Response
     */
    public function show(Request $request, $code)
    {
        return response()->json(null);
    }
}