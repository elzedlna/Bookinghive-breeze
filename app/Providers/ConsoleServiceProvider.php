<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\SendLoginReminders;

class ConsoleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SendLoginReminders::class,
            ]);
        }
    }
} 