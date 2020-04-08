# A Boilerplate for yor Web & API server built
## What is needed to Install?

1. PHP >=7.2 with extension requirements given as in Laravel's documentation.
2. Install web server: apache or nginx
3. Node & NPM LTS Stable Release.
4. Composer Stable Release.
5. Any Database of your choice, I have used MySQL.
6. Install server Redis
7. Install server Elastic search


## A RESTful API features included:

- [Lumen 6x](https://lumen.laravel.com/docs/6.x).
- [JWT Auth](https://github.com/tymondesigns/jwt-auth) for Lumen Application. <sup>[1]</sup>
- [Dingo](https://github.com/dingo/api) to easily and quickly build your own API. <sup>[1]</sup>
- [Lumen Generator](https://github.com/flipboxstudio/lumen-generator) to make development even easier and faster.
- [CORS and Preflight Request](https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS) support.
- [transformer fractal](https://fractal.thephpleague.com/)
- [Laravel Cors](https://github.com/barryvdh/laravel-cors)
- [PHP-VCR](https://github.com/php-vcr/php-vcr)


## Use Packages
- [Beanstalkd](https://beanstalkd.github.io/) support for simple, fast queue work



## What this repo contains?

1. E-Mail Verification/Confirmation for new users.
2. JWT Setup for your APIs.
3. Transform Request Middleware for your boolean inputs in requests.
4. Basic Contracts to Repositories binding sample for Auth Logic.



## For Debugging

- [Sentry](https://github.com/getsentry/sentry-laravel)
- [Bugsnag for Laravel](https://github.com/bugsnag/bugsnag-laravel)

## How you can install?
 
```sh
# Installs all the necessary packages required to run the app
> composer install;

# Creates your dotEnv file
> cp .env.example .env;

# Setup config dingo in 
> .env

# Gives permission to these directories
> chmod -R 777 bootstrap/ storage/;

# Generates app secret
> php artisan key:generate;

# Generates jwt secret
> php artisan jwt:secret;

# Create queue vs queue fail table
> php artisan queue:failed-table
> php artisan queue:table

# Creates the required tables into your database
# Note: Please do remember to create your database before you run this command!
> php artisan migrate;

# Installs all the npm packages
> npm install;

# Run db examlple
> php artisan migrate --seed
```

## How to run the app?

* Run a PHP built in server from your root project:
```sh
    # You can either run it on localhost or you can have the virtualhost configuration 
    # in a server of your choice (We prefer nginx / apache)
    php -S localhost:8000 -t public/ 
 ```
 
 * Or via artisan command:
  ```
    php artisan serve 
  ```

## How can you see Web routes?
```sh
# Lists all the web routes defined for your web-app
php artisan route:list
```

# Todo

### User
* [x] auth/login: Login 
* [x] auth/register; Register
* [x] auth/refresh: Refresh
* [x] auth/user: GetInfo
* [x] auth/user: Update infomation
* [x] auth/password: Thay đổi mật khẩu

### Document other recommend
