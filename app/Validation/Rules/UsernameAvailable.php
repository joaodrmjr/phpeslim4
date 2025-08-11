<?php


namespace App\Validation\Rules;


use Respect\Validation\Rules\Core\Simple;

use App\Models\User;


final class UsernameAvailable extends Simple {

	public function isValid(mixed $input): bool
    {
        if (User::where("username", $input)->count()) {
        	return false;
        }
        return true;
    }

}