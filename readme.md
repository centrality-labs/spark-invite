# Spark Invite
Spark Invite is designed for the use case where user account can been pre-populated, e.g. through information provided by a 3rd party, and an invitation needs to be sent so the prospective user can 'claim' their account.

For example, within a system bulk creation of new user accounts may be required to ensure security, consistency and for convenience. Once a new user account has been created the SparkInvite package can be used to manage the process of the account being claimed. The stages are:

- A referrer, on a referral team (as the referrer may be a member of more than one team), invites the new user account. This is encapsulated in the `Invitation` model.
- An `invite` event is fired, allowing for code outside of the SparkInvite package to verify the invite before issuing any communication. For example, automatic checks for email address domains or manual verification potentially requiring communication by telephone prior to invitation issue.
- An `issued` event is fired allowing for accept/reject links to be issued. The actual sending of the invitation is done outside of the SparkInvites package, allowing your system to use your preference of package/method of communication.
- If the user accepts the invitation the user is immediately asked to reset their password using Spark's standard password reset mechanism. A user may also reject an invitation.
- An invitation can expire, and either soft-expiry (allows for recovery of the invitation unless expired invitations are manually cleaned up) or hard-expiry (once an invitation has expired it cannot be used).

## Installation
- Edit `config\app.php` to have:
```php
    ...
    'providers' => [
        ...
        ZiNETHQ\SparkInvite\SparkInviteServiceProvider::class,
        ...
    ],
    ...
    'aliases' => [
        ...
        'SparkInvite' => ZiNETHQ\SparkInvite\Facades\SparkInvite::class,
        ...
    ],
    ...
```
- Run the command:
```php
php artisan vendor:publish --provider="ZiNETHQ\SparkInvite\SparkInviteServiceProvider"
```
-
- Add the following to your `App\Providers\EventServiceProvider` class:
```php
    protected $listen = [
        ...
        'spark.invite.*' => [
            'App\Listeners\InvitationListener',
        ],
        ...
    ];
```

## Managing errors
When there is an issue with a token, e.g. doesn't exist or has been revoked, the invitation controller redirects back to the route defined in the configuration setting `sparkinvites.routes.on-error`. When redirecting the user one of the `sparkinvites.messages` is passed under the variable name configured by `sparkinvite.flash`, which can be displayed in your view. For example, using Vue.js and Notify.js (plus underscore.string/lodash for capitalization and sprintf for string creation) the following component will do this:
```js
Vue.component('alert', {

    props: {
        message: {
            type: Object,
            required: false,
            default: null
        }
    },

    computed: {
        title: function () {
            return sprintf('<strong>%s</strong>', _string.capitalize(this.message.type));
        },

        type: function () {
            switch (this.message.type) {
                case 'error':
                    return 'danger';
                case 'warning':
                    return 'warning';
                case 'success':
                    return 'success';
                case 'info':
                    return 'info';
                default:
                    return 'danger';
            }
        },

        icon: function() {
            switch (this.type) {
                case 'danger':
                    return 'fa fa-times-circle';
                case 'warning':
                    return 'fa fa-exclamation-triangle';
                case 'success':
                    return 'fa fa-check-circle';
                case 'info':
                    return 'fa fa-info-circle';
                default:
                    return 'fa fa-times-circle';
            }
        }
    },

    template: '',

    created: function () {
        this.$nextTick(function () {
            if (this.message) {
                $.notify({
                    icon: this.icon,
                    title: this.title,
                    message: this.message.content
                },{
                    type: this.type,
                    timer: 3000,
                });
            }
        });
    }

});
```
When used like so on your view page:
```HTML
<alert :message="{{ json_encode(session()->get('alert'), null) }}"></alert>
```