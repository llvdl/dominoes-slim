<?php

namespace Llvdl\Domain\Exception;

class InvalidMatchLeaveException extends \Exception
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function seatAlreadyEmpty(\Exception $previous = null) : InvalidMatchLeaveException
    {
        return new self('The seat is already empty and cannot be unjoined', $previous);
    }

    public static function seatTakenByOther(\Exception $previous = null) : InvalidMatchLeaveException
    {
        return new self('The seat is taken by another account and cannot be unjoined', $previous);
    }
}
