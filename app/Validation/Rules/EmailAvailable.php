<?php


namespace App\Validation\Rules;


use Respect\Validation\Rules\Core\Simple;

use App\Models\User;


final class EmailAvailable extends Simple {

	public function isValid(mixed $input): bool
    {
        if (User::where("email", $input)->count()) {
        	return false;
        }
        return true;
    }

}