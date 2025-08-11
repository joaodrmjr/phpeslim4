<?php


namespace App\Controllers;


use App\Models\User;


class WebController extends Controller {


	public function loginPage($request, $response)
	{
		
		$user = User::find(2);

		return $this->app->get("view")->render($response, "auth/login.twig", [
			"user" => $user
		]);

	}

}