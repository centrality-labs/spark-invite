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

    /*
    |--------------------------------------------------------------------------
    | User models
    |--------------------------------------------------------------------------
    |
    | Specify the local model classes.
    |
    */
    'models'  => [
        'invitation' => 'App\\Invitation',
        'invitation-status' => 'App\\InvitationStatus',
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | Settings for package routes
    |
    */
    'routes' => [
        'accept' => '/invites/accept/{token}',
        'reject' => '/invites/reject/{token}',
        'on-error' => '/',
        'middleware' => [ 'web' ],
        'prefix' => 'zinethq.sparkinvite.'
    ],
    
    /*
    |--------------------------------------------------------------------------
    | HTTPS
    |--------------------------------------------------------------------------
    |
    | Check if the system should generate URLs with
    | https secure_url() or http url()
    |
    */
    'https' => true,

    /*
    |--------------------------------------------------------------------------
    | Expired behaviour
    |--------------------------------------------------------------------------
    |
    | When the user uses an expired invitation, should the package automatically reissue that invitation.
    | That is, a soft- (true) or hard-expiry (false)
    |
    */
    'reissue-on-expiry' => true,


    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    |
    | What prefix to use for event names. Default to spark.invite, but can be customized.
    |
    */
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


    /*
    |--------------------------------------------------------------------------
    | Alerts
    |--------------------------------------------------------------------------
    |
    | How messages are communicated when redirecting the user with errors (e.g.).
    | 'flash' dictates the name of the variable and the messages are the text to be displayed per type of event.
    |
    */
    'flash' => 'alert',
    'messages' => [
        'invalid-token' => 'Not a valid invitation!',
        'pending' => 'Invitation is pending approval. Try again later.',
        'expired' => 'Invitation has expired, a new one has been issued. Please check your email.',
        'revoked' => 'Your invitation was revoked and can no longer be used.',
        'rejected' => 'Your invitation has been rejected.'
    ]
];
