<?php

namespace Pdustdar\DockerizedLaravel\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StopServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docker:stop';

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
        $process = new Process(["docker-compose", "stop"]);
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error($process->getErrorOutput());
        }
        $this->info("Stoped Services.");
    }
}
