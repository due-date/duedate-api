<?php

namespace App\Domain\Validators;

use App\Domain\Enums\ActiveEnum;
use App\Domain\Enums\GenderEnum;
use Illuminate\Validation\Rule;
use Prettus\Validator\Contracts\ValidatorInterface;

class UserValidator extends ValidatorAbstract
{

    public function rule()
    {
        return [
            ValidatorInterface::RULE_CREATE => [
                'name'     => 'required|string|max:255',
                'email'    => ['required', 'email:rfc,dns,spoof,filter,strict', Rule::unique('users', 'email')],
                'password' => 'required|string|min:6',
                'active'   => 'boolean',
                'cpf'      => ['required', 'cpf', Rule::unique('users', 'cpf')],
                'phone'    => ['required', 'regex:/^\+55\d{10}\d?$/'],
                'birth'    => 'required|date|before:-18 years',
                'gender'   => 'nullable|enum:' . GenderEnum::class,
            ],

            ValidatorInterface::RULE_UPDATE => [
                'name'   => 'string|max:255',
                'email'  => ['filled', 'email:rfc,dns,spoof,filter,strict', Rule::unique('users', 'email')],
                'active' => 'boolean',
                'cpf'    => ['filled', 'cpf', Rule::unique('users', 'cpf')->ignore($this->id, 'id')],
                'phone'  => ['filled', 'regex:/^\+55\d{10}\d?$/'],
                'birth'  => 'date|before:-18 years',
                'gender' => 'nullable|enum:' . GenderEnum::class,
            ],
        ];
    }
}
