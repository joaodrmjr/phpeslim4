<?php


namespace App\Controllers;


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

}