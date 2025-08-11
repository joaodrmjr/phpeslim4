<?php


namespace App\Controllers;


use DI\Container as App;


class Controller {


	public function __construct(App $app) {

		$this->app = $app;

	}

}