<?php
// DIC configuration


use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Capsule\Manager as Capsule;
use Jenssegers\Mongodb\Connection;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Http\Request;
use Slim\Http\Response;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new RotatingFileHandler($settings['path'], $settings['maxFiles'], $settings['level']));
    return $logger;
};

$container['loggerAccess'] = function ($c) {
    $settings = $c->get('settings')['loggerAcess'];
    $logger = new Logger($settings['name']);
    $logger->pushProcessor(new UidProcessor());
    $logger->pushHandler(new RotatingFileHandler($settings['path'], $settings['maxFiles'], $settings['level']));
    return $logger;
};


/**
 * MongoDB initializer
 *
 * @param ContainerInterface $container
 *
 * @return Manager
 * @throws Exception
 * @throws ContainerExceptionInterface
 * @throws NotFoundExceptionInterface
 */
$container['errorHandler'] = function ($c) {
    return function (Request $request, Response $response, $exception) use ($c) {
        $response = $c['response'];
        
        return $response
                ->withStatus(400)
                ->withJson([
                    "msg" => $exception->getMessage()
                ]);
    };
};

$container['notAllowedHandler'] = function ($c) {
    return function (Request $request, Response $response, $methods) use ($c) {        
        return $response
                ->withStatus(400)
                ->withJson([
                    "msg" => 'Method must be one of: ' . implode(', ', $methods)
                ]);
    };
};

$container['notFoundHandler'] = function ($c) {
    return function (Request $request, Response $response) use ($c) {        
        return $response
                ->withStatus(400)
                ->withJson([
                    "msg" => "Endpoint not found"
                ]);
    };
};

$container['phpErrorHandler'] = function ($c) {
    return function (Request $request, Response $response, $error) use ($c) {        
        return $response
                ->withStatus(400)
                ->withJson([
                    "msg" => (string)$error
                ]);
    };
};