<?php

namespace Pdustdar\DockerizedLaravel;

use Pdustdar\DockerizedLaravel\DockerCommand;
use Illuminate\Support\ServiceProvider;

class DockerizeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Dockerized' => base_path('Dockerized'),
            __DIR__ . '/../docker-compose.yml' => base_path('docker-compose.yml')

        ]);
        $this->commands([
            DockerCommand::class
        ]);
    }
}
