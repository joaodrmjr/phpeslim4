<?php


namespace App\Controllers;

use Slim\Routing\RouteContext;

use App\Models\User;

use Respect\Validation\Validator as v;
use App\Validation\Validator;


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

		$valid = $this->app->get("validation")->validate($request, [
			"username" => v::noWhitespace()->notEmpty()->length(6, 15)->usernameAvailable(),
			"email" => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
			"password" => v::noWhitespace()->notEmpty()->length(8, 15)
		]);

		if ($valid->failed()) {
			return redirect($request, $response, "registerPage");
		}

		User::create([
			"username" => $data["username"],
			"email" => $data["email"],
			"password" => password_hash($data["password"], PASSWORD_DEFAULT)
		]);

		
		return redirect($request, $response, "home");
	}
}