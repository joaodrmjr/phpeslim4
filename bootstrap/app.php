<?php


use \DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require __DIR__ . "/../vendor/autoload.php";



$container = new Container;


$settings = require __DIR__ . "/../app/config.php";
$settings($container);

$app = SlimAppFactory::create($container);


$middleware = require __DIR__ . "/../app/middleware.php";
$middleware($app);


$container->set("view", function ($app) {
	return Twig::create($app->get("settings")["view"]["template_path"], $app->get("settings")["view"]["twig"]);
});

$app->add(TwigMiddleware::create($app, $container->get("view")));


$container->set("WebController", function ($container) {
	return new \App\Controllers\WebController($container);
});

$routes = require __DIR__ . "/../app/routes.php";
$routes($app);