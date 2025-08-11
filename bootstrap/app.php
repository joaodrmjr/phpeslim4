<?php


// inicia a sessao
session_start();


use \DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

use Illuminate\Database\Capsule\Manager as Capsule;

use Slim\Csrf\Guard;
use Respect\Validation\Factory;



require __DIR__ . "/../vendor/autoload.php";



$container = new Container;


$settings = require __DIR__ . "/../app/config.php";
$settings($container);


AppFactory::setContainer($container);

$app = AppFactory::create();


$responseFactory = $app->getResponseFactory();


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


$container->set("auth", function () use ($container) {
	return new App\Auth\Auth($container);
});


$container->set("view", function ($app) {

	$twig = Twig::create($app->get("settings")["view"]["template_path"], $app->get("settings")["view"]["twig"]);

	return $twig;
});

$app->add(TwigMiddleware::create($app, $container->get("view")));


$container->set("validation", function () {
	return new App\Validation\Validator();
});

$container->set("csrf", function () use ($responseFactory) {
	return new Guard($responseFactory);
});


$container->set("WebController", function ($container) {
	return new \App\Controllers\WebController($container);
});
$container->set("AuthController", function ($container) {
	return new \App\Controllers\AuthController($container);
});


// middlewares
$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputMiddleware($container));
$app->add(new App\Middleware\CsrfViewMiddleware($container));


// respect validation custom
Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Validation\\Rules')
        ->withExceptionNamespace('App\\Validation\\Exceptions')
);

// ativar o CSRF
$app->add("csrf");


$routes = require __DIR__ . "/../app/routes.php";
$routes($app);