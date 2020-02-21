<?php

namespace App\Domain\Validators;

use \Prettus\Validator\LaravelValidator;

abstract class ValidatorAbstract extends LaravelValidator
{

    public function getRules($action = null)
    {
        $rules = $this->rule();

        if (isset($rules[$action])) {
            $rules = $rules[$action];
        }

        return $this->parserValidationRules($rules, $this->id);
    }

    public function rule()
    {
        return [];
    }
}
