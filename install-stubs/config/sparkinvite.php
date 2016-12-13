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

    'routes' => [
        'accept' => '/invites/accept/{token}',
        'reject' => '/invites/reject/{token}'
    ],

    'reissue-on-expiry' => true,

    'event' => [
        'prefix' => 'spark.invite'
        // Available events are:
        // invite - Invitation record has been created
        // reinvite - A previous invitation has expired or has been cancelled and a new invitation created
        // issued - The invitation has passed preconditions and should be sent out to the user
        // expired - The invitation has expired, a new one may be reissued automatically (reissue-on-expiry)
        // accepted - The invitee has accessed the invitation and started the password reset process
        // successful - The user has successfully reset their password
        // revoked - The referrer/a system admin has revoked the invitation
        // rejected - The invitee has rejected the invitation
    ],

    'flash' => 'errors',

    'messages' => [
        'invalid-token' => 'Not a valid invitation!',
        'expired' => 'Invitation has expired, a new one has been issued. Please check your email.',
        'revoked' => 'Your invitation was revoked and can no longer be used.',
        'rejected' => 'Your invitation has been rejected.'
    ]
];
