<?php


namespace App\Controllers;


use App\Models\User;


class WebController extends Controller {


	public function home($request, $response)
	{
		return $this->container->get("view")->render($response, "home.twig");
	}

}