<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
	

	$app->get("/", function (Request $request, Response $response, $args) {
		return $this->get("view")->render($response, "auth/login.twig", [
			'name' => "João"
		]);
	});
};