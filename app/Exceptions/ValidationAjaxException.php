<?php

namespace App\Exceptions;

use Exception;

class ValidationAjaxException extends Exception
{

    public function __construct($validator)
    {
        $this->validator = $validator;
        parent::__construct($this->validator->messages()->first());
    }

    public function render()
    {
        return response()->json([
            'code' => 422,
            'message' => $this->validator->messages()->first()
        ]);
    }
}
