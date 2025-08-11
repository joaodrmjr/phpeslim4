<?php


namespace App\Controllers;


use App\Models\User;


class WebController extends Controller {


	public function home($request, $response)
	{
		return $this->app->get("view")->render($response, "home.twig");
	}

}