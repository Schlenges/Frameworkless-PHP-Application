<?php declare(strict_types = 1);

$injector = new Auryn\Injector;

/* $injector->alias('Http\Request', 'Symfony\Component\HttpFoundation\Request'); */
$injector->share('Symfony\Component\HttpFoundation\Request');
$injector->define('Symfony\Component\HttpFoundation\Request', [
    ':get' => $_GET,
    ':post' => $_POST,
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER,
]);

/* $injector->alias('Http\Response', 'Symfony\Component\HttpFoundation\Response'); */
$injector->share('Symfony\Component\HttpFoundation\Response');

return $injector;