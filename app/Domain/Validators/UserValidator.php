<?php

namespace App\Domain\Validators;

use App\Domain\Enums\ActiveEnum;
use Illuminate\Validation\Rule;
use Prettus\Validator\Contracts\ValidatorInterface;

class UserValidator extends ValidatorAbstract
{

    public function rule()
    {
        return [
            ValidatorInterface::RULE_CREATE => [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'active'   => 'boolean'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name'   => 'string|max:255',
                'email'  => 'string|email|max:255|unique:users',
                'active'   => 'boolean'
            ]
        ];
    }
}
