<?php

namespace Pdustdar\DockerizedLaravel\Console;

use Illuminate\Console\Command;
use RuntimeException;
use Symfony\Component\Process\Process;

class StartServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docker:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $process = new Process(["docker-compose","up","-d"]);
        $process->run();
        if (!$process->isSuccessful()) {
            if(str_contains($process->getErrorOutput(),"address already in use"))
                throw new RuntimeException($process->getErrorOutput());
        }
        print $process->getOutput();
        
    }

}
