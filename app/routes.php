<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
	

	$app->get("/", "WebController:home")->setName("home");


	$app->get("/login", "AuthController:loginPage")->setName("loginPage");
	$app->post("/login", "AuthController:postLogin");

	$app->get("/register", "AuthController:registerPage")->setName("registerPage");
	$app->post("/register", "AuthController:postRegister");


	$app->get("/logout", "AuthController:logout")->setName("logout");
};