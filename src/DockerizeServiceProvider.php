<?php

namespace Pdustdar\DockerizedLaravel;

use Illuminate\Support\ServiceProvider;
use Pdustdar\DockerizedLaravel\Console\PublishCommand;
use Pdustdar\DockerizedLaravel\Console\StartServiceCommand;
use Pdustdar\DockerizedLaravel\Console\StopServiceCommand;

class DockerizeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StopServiceCommand::class,
                StartServiceCommand::class,
                PublishCommand::class,
            ]);
            $this->publishes([
                __DIR__ . '/../config/deploy.php' => $this->app->configPath('deploy.php'),
            ], "dockerized");
        }
    }
    public function provides()
    {
        return [
            StopServiceCommand::class,
            StartServiceCommand::class,
            PublishCommand::class,
        ];
    }
}
