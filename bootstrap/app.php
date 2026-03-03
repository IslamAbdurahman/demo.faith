<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

function tash_time(){
    $date = \Carbon\Carbon::now('Asia/Tashkent')->format('Y-m-d H:i:s');
    return $date;
}

function tash_date(){
    $date = \Carbon\Carbon::now('Asia/Tashkent')->format('Y-m-d');
    return $date;
}

function limit_students(){
    $limit = Http::accept('application/json')->get('faith.uz/expire',[
                    'url'=>$_SERVER['HTTP_HOST']
                ])->object()->limit;

    return $limit;

}

function expire(){
    try {
        $expire = round((strtotime(
                    Http::accept('application/json')->get('faith.uz/expire',[
                        'url'=>$_SERVER['HTTP_HOST']
                    ])->object()->data)-strtotime(date('Y-m-d H:i:s')))/(24*60*60),2);

        return $expire;
    }catch (Exception $exception){
        return 0;
    }


}

function expire_date(){

    try {
        $date = Http::accept('application/json')->get('faith.uz/expire',[
            'url'=>$_SERVER['HTTP_HOST']
        ])->object()->data;

        return date('Y-m-d', strtotime($date));
    }catch (Exception $exception){
        return date('Y-m-d');
    }

}

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
