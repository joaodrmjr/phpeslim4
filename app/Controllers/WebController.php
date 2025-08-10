<?php


namespace App\Controllers;


class WebController extends Controller {


	public function loginPage($request, $response) {

		return $this->app->get("view")->render($response, "auth/login.twig", [
			"name" => "Marcelao"
		]);

	}

}