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
