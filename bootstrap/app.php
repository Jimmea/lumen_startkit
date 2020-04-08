<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->instance('path.public', app()->basePath() . DIRECTORY_SEPARATOR . 'public');
$app->instance('path.storage', app()->basePath() . DIRECTORY_SEPARATOR . 'storage');

$app->withFacades();
$app->withEloquent();

date_default_timezone_set('Asia/Ho_Chi_Minh');
collect(scandir(__DIR__ . '/../config'))->each(function ($item) use ($app) {
    $app->configure(basename($item, '.php'));
});
$app->configure('modules');
$app->configure('debugbar');


$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->bind(\Illuminate\Contracts\Routing\UrlGenerator::class, function ($app) {
    return new \Laravel\Lumen\Routing\UrlGenerator($app);
});

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
*/
 $app->middleware([
    'locale' => App\Http\Middleware\ChangeLocale::class
 ]);

$app->middleware([
    App\Http\Middleware\CORSMiddleware::class,
]);

$app->routeMiddleware([
//    'cors' => palanik\lumen\Middleware\LumenCors::class,
//    'serializer' => \Liyu\Dingo\SerializerSwitch::class,
    'auth' => App\Http\Middleware\Authenticate::class,
    'api.auth.jwt'=> \App\Http\Middleware\JwtMiddleware::class,
]);


/*
|--------------------------------------------------------------------------
| Register Service Providers
*/
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(Dingo\Api\Provider\LumenServiceProvider::class);
$app->register(Illuminate\Session\SessionServiceProvider::class);

// Package services provider
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(\Nwidart\Modules\LumenModulesServiceProvider::class);

$app->singleton(Illuminate\Auth\AuthManager::class, function ($app) {
    return $app->make('auth');
});
$app->singleton('cookie', function () use ($app)
{
    return $app->loadComponent('session', 'Illuminate\Cookie\CookieServiceProvider', 'cookie');
});
$app->bind('Illuminate\Contracts\Cookie\QueueingFactory', 'cookie');


if (env('APP_DEBUG')) {
    $app->register(Barryvdh\Debugbar\LumenServiceProvider::class);
}

$app->register(\App\Providers\LoadPackageServiceProvider::class);
$app->register(Irazasyed\Larasupport\Providers\ArtisanServiceProvider::class);

$app->alias('Artisan', \Illuminate\Support\Facades\Artisan::class);


$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/api/v1.php';
    require __DIR__.'/../routes/web.php';
});
return $app;
