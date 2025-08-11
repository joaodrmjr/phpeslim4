<?php


namespace App\Controllers;

use Slim\Routing\RouteContext;

use App\Models\User;

use Respect\Validation\Validator as v;
use App\Validation\Validator;


class AuthController extends Controller {


	public function loginPage($request, $response)
	{
		return $this->container->get("view")->render($response, "auth/login.twig");

	}


	public function postLogin($request, $response)
	{
		$data = $request->getParsedBody();
		
		$attemp = $this->container->get("auth")->attemp($data);

		if (!$attemp) {
			$this->container->get("flash")->addMessage("error", $this->container->get("auth")->error());
			return redirect($request, $response, "loginPage");
		}

		$this->container->get("flash")->addMessage("success", "Login realizado com sucesso!");
		return redirect($request, $response, "home");
	}


	public function registerPage($request, $response)
	{
		return $this->container->get("view")->render($response, "auth/register.twig");
	}

	public function postRegister($request, $response)
	{
		$data = $request->getParsedBody();

		$valid = $this->container->get("validation")->validate($request, [
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