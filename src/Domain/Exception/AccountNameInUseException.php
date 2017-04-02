<?php

namespace Llvdl\Domain\Exception;

class AccountNameInUseException extends \Exception
{
    public function __construct($name, \Exception $previous = null)
    {
        $message = sprintf('Account name "%s" is already in use', $name);
        parent::__construct($message, 0, $previous);
    }
}
