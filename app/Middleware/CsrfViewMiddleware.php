<?php

namespace App\Middleware;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class CsrfViewMiddleware implements MiddlewareInterface {

	protected $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function process(Request $request, RequestHandler $handler): Response
	{
		$csrf = $this->container->get("csrf");
		$nameKey = $csrf->getTokenNameKey();
		$valueKey = $csrf->getTokenValueKey();
		$name = $request->getAttribute($nameKey);
		$value = $request->getAttribute($valueKey);
		$this->container->get("view")->getEnvironment()->addGlobal("csrf", [
			"field" => "
				<input type='hidden' name='$nameKey' value='$name'></input>
				<input type='hidden' name='$valueKey' value='$value'></input>
			"
		]);

		$response = $handler->handle($request);
		

		return $response;
	}

}
