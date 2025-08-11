<?php

use \Psr\Container\ContainerInterface;

return function (ContainerInterface $container) {
	$container->set("settings", function () {
		return [
			'displayErrorDetails' => true,
			'logErrorDetails' => true,
			'logErrors' => true,

			'view' => [
				'template_path' => __DIR__ . "/../resources/views",
				'twig' => [
					'cache' => __DIR__ . "/../cache/twig",
					'debug' => true,
					'auto_reload' => true
				]

			],

			"auth_session" => "23fd896ff7970ceba51fadafdf58e23d",

			"db" => [
				"driver" => "mysql",
				"host" => "localhost",
				"database" => "slim4",
				"username" => "root",
				"password" => "",
				"charset" => "utf8",
				"collation" => "utf8_unicode_ci",
				"prefix" => ""
			]
		];
	});
};