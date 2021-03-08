<?php

namespace Pdustdar\DockerizedLaravel\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'docker:publish';
    protected $description = 'Publish the Docker files';
    public function handle()
    {
        $this->call('optimize:clear');
        $this->call('vendor:publish', ['--tag' => 'dockerized']);
        return 0;
    }
}
