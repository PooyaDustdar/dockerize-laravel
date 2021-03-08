<?php
namespace Pdustdar\DockerizedLaravel;

use Illuminate\Support\ServiceProvider;
use Pdustdar\DockerizedLaravel\Console\InstallCommand;
use Pdustdar\DockerizedLaravel\Console\PublishCommand;
use Pdustdar\DockerizedLaravel\Console\StartServiceCommand;

class DockerizeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([            
                StartServiceCommand::class,
                InstallCommand::class,
                PublishCommand::class,
            ]);
            $this->publishes([
                __DIR__ . '/../docker-compose.yml' => $this->app->basePath('docker-compose.yml'),
                __DIR__ . '/../Dockerized' => $this->app->basePath('Dockerized'),
            ],"dockerized");
            
        }
    }
    public function provides()
    {
        return [
            StartServiceCommand::class,
            InstallCommand::class,
            PublishCommand::class,
        ];
    }
}
