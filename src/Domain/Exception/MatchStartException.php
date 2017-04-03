<?php

namespace Llvdl\Domain\Exception;

class MatchStartException extends \Exception
{
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function cantStart(\Exception $previous = null) : InvalidMatchLeaveException
    {
        return new self('The match cannot be started', $previous);
    }

    public static function stateNotStartable(\Exception $previous = null) : InvalidMatchLeaveException
    {
        return new self('The match is not in a startable state ', $previous);
    }
}
