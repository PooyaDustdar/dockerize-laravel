# dockerize-laravel
Easy Deploy Dockerized Laravel Framework With Nginx (Production).

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
you can create and publish docker file and settign ofter install and register provider. run this:

```sh
php artisan docker:publish
```

## Start and Stop services
ofter create and publish docker files you can run services with this:
```sh
php artisan docker:up
```
And for Stop Service:
```sh
php artisan docker:stop
``` 
