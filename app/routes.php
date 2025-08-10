<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

return function (AppFactory $app) {
	

	$app->get("/", function (Request $request, Response $response, $args) {
		
	});
};