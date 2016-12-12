<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Spark Invite Expiration Default
    |--------------------------------------------------------------------------
    |
    | Default Expiry time in Hours from current time.
    | i.e now() + expires (hours)
    |
    */
    'expires' => 48,

    'reissue-on-expiry' => true,

    'event' => [
        'prefix' => 'spark.invite'
        // Available events are:
        // invite - Invitation record has been created
        // reissue - A previous invitation has expired or has been cancelled and a new invitation created
        // expired - The invitation has expired, a new one may be reissued automatically (reissue-on-expiry)
        // accepted - The invitee has accessed the invitation and started the password reset process
        // successful - The user has successfully reset their password
        // cancelled - The referrer/a system admin has cancelled the invitation
    ],

    'flash' => 'errors',

    'messages' => [
        'invalid-token' => 'Not a valid invitation!',
        'expired' => 'Invitation has expired, a new one has been issued. Please check your email.',
        'cancelled' => 'Your invitation has been cancelled.'
    ]
];
