<?php


namespace App\Auth;


use DI\Container;


use App\Models\User;


class Auth {

	const NONE = 0;
	const LOGGED = 1;



	protected $container, $config;


	protected $error, $obj;


	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->config = $container->get("settings");
	}

	public function attemp(array $params): bool
	{

		$username = $params["username"];
		$password = $params["password"];


		if (empty($username) && empty($password)) {
			$this->error = "Por favor, preencha todos os campos";
			return false;
		}


		if (!$user = User::where("username", $username)->orWhere("email", $username)->first()) {
			$this->error = "Email ou nome de usuário não encontrado";
			return false;
		}

		if (!password_verify($password, $user->password)) {
			$this->error = "A senha inserida está incorreta";
			return false;
		}

		$_SESSION[$this->config["auth_session"]] = $user->id;

		return true;

	}


	public function logout()
	{
		unset($_SESSION[$this->config["auth_session"]]);
	}


	public function check(): int
	{
		$s = $_SESSION[$this->config["auth_session"]] ?? null;

		if (User::find($s)) {
			return self::LOGGED;
		}

		return self::NONE;
	}

	public function user(): ?User
	{
		$s = $_SESSION[$this->config["auth_session"]] ?? null;
		return User::find($s);
	}

	public function error()
	{
		return $this->error;
	}

}