<?php

namespace Pdustdar\DockerizedLaravel\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'docker:publish';
    protected $description = 'Publish the Docker files';
    protected $services = [
        "composer" => "RUN php -r \"readfile('http://getcomposer.org/installer');\" | php -- --install-dir=/usr/bin/ --filename=composer",
        "curl" => "RUN apt-get install -y curl php8.0-curl",
        "zip" => "RUN apt-get install -y zip unzip libzip-dev php8.0-zip",
        "sqlite" => "RUN apt-get install -y sqlite3",
        "jdk" => "RUN apt-get install -y openjdk-11-jre",
        "mysql" => "RUN apt-get install -y mysql-client php8.0-mysql",
        "mongodb" => "RUN apt-get install -y php8.0-mongodb",
        "redis" => "RUN apt-get install -y php8.0-redis",
        "pgsql" => "RUN apt-get install -y php8.0-pgsql",
        "soap" => "RUN apt-get install -y php8.0-soap",
        "imap" => "RUN apt-get install -y php8.0-imap",
        "ldap" => "RUN apt-get install -y php8.0-ldap",

        "gd" => [
            "RUN apt-get install -y php8.0-gd ",
            "jpeg" => "libjpeg-dev ",
            "freetype" => "libfreetype6-dev ",
            "webp" => "webp libwebp-dev ",
            "png" => "libpng-dev"
        ],
        "devtools" => [
            "RUN apt-get install -y ",
            "nano" => "nano ",
            "htop" => "htop ",
            "git" => "git ",
            "nmap" => "nmap ",
            "net-tools" => "net-tools ",
            "iputils-ping" => "iputils-ping",
        ],

    ];


    public function handle()
    {
        $this->call('optimize:clear');
        $this->call('vendor:publish', ['--tag' => 'dockerized']);

        $selected_services = $this->selectServices();
        $gd_config = $this->selectGDStatus();
        $dev_tools = $this->selectDevTools();
        $need_install = $this->getInstalltion($selected_services, $gd_config, $dev_tools);
        $docker_file = implode("\n", $need_install);
        $this->publishDockerCompose($selected_services);
        $this->publishDockerfile($docker_file);
        return 0;
    }



    protected function selectGDStatus()
    {
        $gd = $this->confirm("Do you use GD?");
        if ($gd) {
            return $this->choice('Please Select Support Formats:(use , for multiple)', [
                "webp",
                "jpeg",
                "png",
                "jpeg",
                "freetype",

            ], 0, null, true);
        }
        return false;
    }

    protected function selectDevTools()
    {
        $dev_tools = $this->confirm("Do you need DevTools?");
        if ($dev_tools) {
            return $this->choice('Please Select Tools:(use , for multiple)', [
                "nano",
                "htop",
                "git",
                "nmap",
                "net-tools",

            ], 0, null, true);
        }
        return false;
    }
    protected function selectServices()
    {
        return $this->choice('Which services would you like to install?', [
            "composer",
            "curl",
            "zip",
            "sqlite",
            "jdk",
            "mysql",
            "mongodb",
            "redis",
            "pgsql",
            "soap",
            "imap",
            "ldap",
        ], null, null, true);
    }

    protected function getInstalltion($selected_services, $gd_config, $dev_tools)
    {
        $docker_file = [];
        foreach ($selected_services as $selected_service)
            $docker_file[] = $this->services[$selected_service];

        if ($gd_config !== false) {
            $gd_apt = $this->services['gd'][0];
            foreach ($gd_config as $config)
                $gd_apt .= $this->services['gd'][$config];
            $docker_file[] = $gd_apt;
        }
        if ($dev_tools !== false) {
            $dev_apt = $this->services['devtools'][0];
            foreach ($dev_tools as $config)
                $dev_apt .= $this->services['devtools'][$config];
            $docker_file[] = $dev_apt;
        }
        return $docker_file;
    }
    protected function publishDockerCompose($services)
    {
        $services_compose = '';
        foreach ($services as $service) {
            if (file_exists(__DIR__ . "/../../stubs/${service}.stub")) {
                $gd = $this->confirm("do you need run ${service} service in your localhost?");
                if ($gd) {
                    $services_compose .= file_get_contents(__DIR__ . "/../../stubs/$service.stub");
                }
            }
        }
        $docker_compose_base = file_get_contents(__DIR__ . "/../../stubs/docker-compose.stub");
        $docker_file = str_replace("{{services}}", $services_compose, $docker_compose_base);
        file_put_contents($this->laravel->basePath('docker-compose.yml'), $docker_file);
    }
    protected function publishDockerfile($services)
    {
        $docker_base = file_get_contents(__DIR__ . "/../../stubs/dockerfile.stub");
        $docker_file = str_replace("{{services}}", $services, $docker_base);
        if(!file_exists($this->laravel->basePath('Dockerized')))
            mkdir($this->laravel->basePath('Dockerized'));
        file_put_contents($this->laravel->basePath('Dockerized/Dockerfile'), $docker_file);
        file_put_contents($this->laravel->basePath('Dockerized/php.ini'), file_get_contents(__DIR__."/../Dockerized/php.ini"));
        file_put_contents($this->laravel->basePath('Dockerized/www.conf'), file_get_contents(__DIR__."/../Dockerized/www.conf"));
        file_put_contents($this->laravel->basePath('Dockerized/nginx.conf'), file_get_contents(__DIR__."/../Dockerized/nginx.conf"));
        file_put_contents($this->laravel->basePath('Dockerized/fastcgi_params'),file_get_contents(__DIR__."/../Dockerized/fastcgi_params"));
        file_put_contents($this->laravel->basePath('Dockerized/bash.sh'),file_get_contents(__DIR__."/../Dockerized/bash.sh"));
    }
}
