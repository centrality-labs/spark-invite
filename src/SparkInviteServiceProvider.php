<?php
namespace ZiNETHQ\SparkInvite;

use Blade;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

use ZiNETHQ\SparkInvite\SparkInvite;

class SparkInviteServiceProvider extends ServiceProvider
{
    /**
     * Indicates of loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider
     *
     * @return null
     */
    public function boot()
    {
        $this->publish();
    }

    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../install-stubs/config/sparkinvite.php',
            'sparkinvite'
        );

        $this->app->singleton('spark.invite', function ($app) {
            return new SparkInvite();
        });
    }

    /**
     * Construct the array of files to publish
     *
     * @return void
     */
    protected function publish()
    {
        $publishes = [];
        $date = Carbon::now();
        $stubs = __DIR__.'/../install-stubs';

        foreach ($this->getMigrations() as $key => $migration) {
            $exists = glob(database_path("/migrations/*_{$migration}.php"));
            $timestamp = $date->addSeconds($key)->format('Y_m_d_His');
            $filename = ($exists && count($exists) === 1) ? $exists[0] : database_path("migrations/{$timestamp}_{$migration}.php");
            $publishes["{$stubs}/database/migrations/{$migration}.php"] = $filename;
        }
        $publishes[realpath("{$stubs}/config")] = config_path();
        $publishes[realpath("{$stubs}/model")] = app_path();

        $this->publishes($publishes);
    }

    /**
     * Get the appropriate migration files in the correct order to be applied
     *
     * @return array
     */
    protected function getMigrations()
    {
        return [
            'create_user_invitations_table',
        ];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sparkinvite'];
    }
}
