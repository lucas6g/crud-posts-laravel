# Parlador Ideal

> ### Example of how to run Parlador Ideal  an api rest for de mobile app at repo.(https://github.com/lucas6g/parlador-ideal-mobile)

----------

# Getting started

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

Make sure you have all the necessary requirements to run a laravel project in version 8.

## Installation

Clone the repository

    git clone github.com/lucas6g/parlador-ideal-backend

Switch to the repo folder

    cd parlador-ideal-backend

Install all the dependencies using composer

    composer install --ignore-platform-reqs

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000


**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate

    php artisan serve

## Database seeding

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

Any route of api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).


----------

# Code overview

## Dependencies

- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens
- [fruitcake/laravel-cors](https://github.com/fruitcake/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)
- [league/flysystem-aws-s3-v3](https://packagist.org/packages/league/flysystem-aws-s3-v3) -For handling Aws s3 image Upload Flysystem adapter for the AWS S3 SDK v3.x

## Folders

- `app/Models` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Protocols/Repositories` - Contains repository pattern interfaces
- `app/Protocols/Providers` - Contains services providers interfaces
- `app/Providers` - Contains Services Providers
- `app/Repositories` - Contains Orm Repositories
- `app/Services` - Contains Services to handle Business Logic Application
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Unit` - Contains all the api unit tests
- `tests/Unit/Fakes` - Contains all Fakes for Repositories and Providers

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel test to run all unit tests 

    php artisan test

---------

# Authentication

This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.

- https://jwt.io/introduction/


----------

# Cross-Origin Resource Sharing (CORS)

This applications has  CORS global middleware to  enabled by default on all API endpoints. 

- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS

