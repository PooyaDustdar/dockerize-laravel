<?php

namespace Pdustdar\DockerizedLaravel;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DockerCommand extends Command
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
    protected $description = 'Run Docker Compose';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $process = new Process(['docker-compose', 'up', '-d']);
        $process->run();
        if (!$process->isSuccessful())
            throw new ProcessFailedException($process);
        dd($process->getOutput());
        return 0;
    }
}
