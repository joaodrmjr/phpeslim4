<?php



namespace App\Middleware;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class GuestMiddleware implements MiddlewareInterface {

	protected $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function process(Request $request, RequestHandler $handler): Response
	{
		$state = $this->container->get("auth")->check();

		if ($state) {
			$this->container->get("flash")->addMessage("info", "Acesso não permitido :/");
		}


		$response = $handler->handle($request);

		if ($state) {
			return redirect($request, $response, "home");
		}

		return $response;

	}

}