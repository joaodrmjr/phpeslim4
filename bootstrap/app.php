<?php


use \DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request; 


require __DIR__ . "/../vendor/autoload.php";



$container = new Container;


$settings = require __DIR__ . "/../app/config.php";
$settings($container);


AppFactory::setContainer($container);

$app = AppFactory::create();


$middleware = require __DIR__ . "/../app/middleware.php";
$middleware($app);


$container->set("view", function ($app) {
	return Twig::create($app->get("settings")["view"]["template_path"], $app->get("settings")["view"]["twig"]);
});

$app->add(TwigMiddleware::create($app, $container->get("view")));



$routes = require __DIR__ . "/../app/routes.php";
$routes($app);