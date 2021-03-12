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
        $process = new Process(["docker-compose", "up", "-d", "--quiet-pull"]);
        $process->setTimeout(0);
        $process->run();
        if (!$process->isSuccessful()) {
            $error = $process->getErrorOutput();
            $errors = explode("ERROR:", $error);
            $echo = true;
            foreach ($errors as $value) {
                if (str_contains($value, "address already in use")) {
                    $message = explode("listen tcp", $value)[1];
                    $message = substr($message, 0, strpos($message, "\n"));
                    $this->error($message);
                    $echo = false;
                }
            }

            if (str_contains($error, "HTTP 403")) {
                $this->error("your can not access to docker hub from this region.");
                $echo = false;
            }
            if ($echo) {
                echo $error;
            }
            die();
        }
        $this->info("Start Services.");
    }
}
