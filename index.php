<?php

declare(strict_types=1);

//debug fn
require_once 'src/utils/debug.php';

spl_autoload_register(function ($name) {
    //composer !!!
    $name = str_replace(['App\\', '\\'], ['', '/'], $name);
    $path = "src/$name.php";
    require_once $path;
});

use App\Request;
use App\Exception\AppException;
use App\Controllers\Controller;


try {
    $request = new Request($_GET, $_POST, $_SERVER);
    Controller::initConfiguration(require_once 'src/config/config.php');
    (new Controller($request))->run();
} catch (AppException $e) {
    echo '<h1>Wystąpił błąd aplikacji</h1>';
    echo "<h3>{$e->getMessage()}</h3>";
} catch (\Throwable $e) {
    dump($e);
    echo '<h1>Wystąpił błąd aplikacji</h1>';
};