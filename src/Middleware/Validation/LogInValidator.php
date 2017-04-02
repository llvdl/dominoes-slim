<?php

namespace Llvdl\Middleware\Validation;

use DavidePastore\Slim\Validation\Validation;
use Respect\Validation\Validator as v;

class LogInValidator extends Validation
{
    public function __construct()
    {
        $validators = [
            'name' => v::notBlank(),
            'password' => v::notBlank()
        ];

        parent::__construct($validators);
    }
}
