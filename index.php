<?php declare(strict_types=1);

use adRespect\Controllers\PageController;
use adRespect\Exceptions\AppException;
use adRespect\Middlewares\DotEnv;
use adRespect\View\{View, Router};


date_default_timezone_set('Europe/Warsaw');

spl_autoload_register(function (string $classNamespace) {

    $path = str_replace(['\\', 'adRespect/'], ['/', ''], $classNamespace);
    $path = 'src' . DIRECTORY_SEPARATOR . $path . '.php';

    require_once $path;

});


try {

    (new DotEnv(__DIR__ . '/.env'))->load();

    (new PageController(new View(), new Router()));

} catch (AppException $e) {
    echo $e->getMessage();
} catch (Throwable $e) {
    echo $e->getMessage();
}