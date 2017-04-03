<?php

namespace Llvdl\Domain;

use Llvdl\Domain\Exception\MatchStartException;

class MatchState
{
    const ID_NEW = 'new';
    const ID_IN_PROGRESS = 'in_progress';

    /** @var string */
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Constructs a Match State instance by id, as return by self::__toString.
     */
    public static function createFromString(string $id) : MatchState
    {
        if (!in_array($id, self::getIds())) {
            throw new \InvalidArgumentException(sprintf('invalid id "%s" for match state', $id));
        }

        return new self($id);
    }

    public static function createNew() : MatchState
    {
        $state = MatchState::createFromString(self::ID_NEW);

        return $state;
    }

    public function canStart()
    {
        return $this->id == self::ID_NEW;
    }

    public function moveToStarted() : MatchState
    {
        if (!$this->canStart()) {
            throw MatchStartException::stateNotStartable($this->__toString());
        }

        return new self(self::ID_IN_PROGRESS);
    }

    public function __toString() : string
    {
        return (string) $this->id;
    }

    /** @return string[] */
    private static function getIds() : array
    {
        return [
            self::ID_NEW,
            self::ID_IN_PROGRESS
        ];
    }
}
