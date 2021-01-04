<?php declare(strict_types = 1);

namespace Example;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

/**
* Register the error handler
*/
$whoops = new \Whoops\Run;

if ($environment !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function($e){
        echo 'Todo: Friendly error page and send an email to the developer';
    });
}

$whoops->register();

/* throw new \Exception; */


/**
 * Create Request and Response Objects
 */
$request = Request::createFromGlobals();

$response = new Response(
  'Content',
  Response::HTTP_OK,
  ['content-type' => 'text/html']
);

/* $response->setContent('Hello World');
$response->send(); */

/** 
 * Add Routing
*/
$dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
  $r->addRoute('GET', '/hello-world', function () {
      echo 'Hello World';
  });
  $r->addRoute('GET', '/another-route', function () {
      echo 'This works too';
  });
});

$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '08')) {
    $uri = substr($uri, $pos+2);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $uri);
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func($handler, $vars);
        break;
}