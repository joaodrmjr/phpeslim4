<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


return function (App $app) {

	$settings = $app->getContainer()->get("settings");


	$app->addRoutingMiddleware();

	$app->addErrorMiddleware(
		$settings["displayErrorDetails"],
		$settings["logErrors"],
		$settings["logErrorDetails"]
	);
};