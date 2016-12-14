# Spark Invite

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
When there is an issue with a token, e.g. doesn't exist or has been revoked, the invitation controller redirects back to the route defined in the configuration setting `sparkinvites.routes.on-error`. When redirecting the user on of the `sparkinvites.messages` is passed under the variable name configured by `sparkinvite.flash`, which can be displayed in your view. For example, using Vue.js and Notify.js (plus underscore.string/lodash for capitalization and sprintf for string creation) the following component will do this:
```js
Vue.component('alert', {

    props: {
        messages: Array
    },

    data: function () {
        return {

        };
    },

    template: '',

    created: function () {
        var message;
        for (message of this.messages) {
            $.notify({
                icon: 'font-icon fa fa-times-circle',
                title: sprintf('<strong>%s</strong>', _string.capitalize(message.type)),
                message: message.content
            },{
                type: message.type
            });
        }
    }

});
```
When used like so on your view page:
```HTML
<alert messages="{{ $alerts ? $alerts : [] }}"></alert>
```