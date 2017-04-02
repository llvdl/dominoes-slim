<?php

namespace Llvdl\Middleware\Validation;

use DavidePastore\Slim\Validation\Validation;
use Respect\Validation\Validator as v;

class CreateMatchValidator extends Validation
{
    public function __construct()
    {
        $validators = [
            'name' => v::notBlank()
        ];

        parent::__construct($validators);
    }
}
