<?php


namespace Shibby\Mesnot;

use Illuminate\Support\ServiceProvider;
use Shibby\Mesnot\Commands\MesnotSyncUserCommand;

class MesnotServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Resources/config/mesnot.php' => config_path('mesnot.php'),
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                MesnotSyncUserCommand::class
            ]);
        }
    }

    public function register()
    {
    }
}
