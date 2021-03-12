# Dockerize Laravel
Easy Deploy Dockerized Laravel App With Nginx (Production).

## Installation using [Composer](https://getcomposer.org/)
In your terminal application move to the root directory of your laravel project using the `cd` command and require the project as a dependency using composer.
```sh
composer require pdustdar/dockerize-laravel
```
And run this for register commends:
```sh
php artisan vendor:publish --provider=Pdustdar\DockerizedLaravel\DockerizeServiceProvider
```

## Create And Publish docker files and configurations 
You can create and publish docker file and setting after install and register provider. run this:

```sh
php artisan docker:publish
```

## Start and Stop services
After creating and publishing the docker files, you can run the services by:
```sh
php artisan docker:up
```
And to stop the service:
```sh
php artisan docker:stop
``` 
