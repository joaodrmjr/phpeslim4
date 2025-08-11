<?php


namespace App\Controllers;

use Slim\Routing\RouteContext;

use App\Models\User;


class AuthController extends Controller {


	public function loginPage($request, $response)
	{
		return $this->app->get("view")->render($response, "auth/login.twig");

	}

	public function registerPage($request, $response)
	{
		return $this->app->get("view")->render($response, "auth/register.twig");
	}

	public function postRegister($request, $response)
	{
		$data = $request->getParsedBody();


		User::create([
			"username" => $data["username"],
			"email" => $data["email"],
			"password" => password_hash($data["password"], PASSWORD_DEFAULT)
		]);

		$routeParser = RouteContext::fromRequest($request)->getRouteParser();
		$url = $routeParser->urlFor("registerPage");

		return $response->withHeader('Location', $url)->withStatus(302);
	}
}