<?php

namespace Pdustdar\DockerizedLaravel\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'docker:install';
    protected $description = 'Install the Docker library';
    public function handle()
    {
        dd($this->choice('Which database would you like to install? (forselect multiple splet with "," Exp: 0,1)', 
        [
            'mysql',
            'mongodb'
        ], 0, null, true));
       return 0;
    }
}
