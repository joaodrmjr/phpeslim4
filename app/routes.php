<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
	

	$app->get("/", "WebController:home")->setName("home");


	$app->group("/auth", function (RouteCollectorProxy $group) use ($app) {

		$group->get("/login", "AuthController:loginPage")->setName("loginPage");
		$group->post("/login", "AuthController:postLogin");

		$group->get("/register", "AuthController:registerPage")->setName("registerPage");
		$group->post("/register", "AuthController:postRegister");

	})->add(new \App\Middleware\GuestMiddleware($app->getContainer()));



	$app->group("/user", function (RouteCollectorProxy $group) use ($app) {

		$group->get("/logout", "AuthController:logout")->setName("logout");
	});
	
};