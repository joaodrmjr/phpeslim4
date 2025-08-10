<?php


use \DI\Container;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Factory\AppFactory;


require __DIR__ . "/../vendor/autoload.php";


$container = new Container;


$settings = require __DIR__ . "/../app/config.php";
$settings($container);


AppFactory::setContainer($container);

$app = AppFactory::create();


$middleware = require __DIR__ . "/../app/middleware.php";
$middleware($app);


$container->set("view", function () {
	return Twig::create(__DIR__ . "/../resources/views", ['cache' => false]);
});

$app->add(TwigMiddleware::create($app, $container->get("view")));


$app->get("/", function ($require, $response) {
	$view = $this->get("view");


	return $view->render($response, "auth/home.twig", ['name' => "Marcelo"]);
});