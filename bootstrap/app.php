<?php


use \DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . "/../vendor/autoload.php";



$container = new Container;


$settings = require __DIR__ . "/../app/config.php";
$settings($container);


AppFactory::setContainer($container);

$app = AppFactory::create();



$middleware = require __DIR__ . "/../app/middleware.php";
$middleware($app);

// database
$capsule = new Capsule();
$capsule->addConnection($container->get("settings")["db"]);
$capsule->setAsGlobal();
$capsule->bootEloquent();


$container->set("db", function ($app) use ($capsule) {
	return $capsule;
});


$container->set("view", function ($app) {
	return Twig::create($app->get("settings")["view"]["template_path"], $app->get("settings")["view"]["twig"]);
});

$app->add(TwigMiddleware::create($app, $container->get("view")));


$container->set("validation", function () {
	return new App\Validation\Validator();
});


$container->set("WebController", function ($container) {
	return new \App\Controllers\WebController($container);
});
$container->set("AuthController", function ($container) {
	return new \App\Controllers\AuthController($container);
});

$routes = require __DIR__ . "/../app/routes.php";
$routes($app);