<?php

namespace Llvdl\Domain\Exception;

class InvalidMatchJoinException extends \Exception
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function seatAlreadyTaken(\Exception $previous = null) : InvalidMatchJoinException
    {
        return new self('The seat is already taken and cannot be joined', $previous);
    }
}
