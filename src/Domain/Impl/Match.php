<?php

namespace Llvdl\Domain\Impl;

use Llvdl\Domain;
use Jenssegers\Mongodb\Eloquent\Model;
use Llvdl\Domain\Exception\InvalidMatchJoinException;
use Llvdl\Domain\Exception\InvalidMatchLeaveException;

class Match extends Model implements Domain\Match
{
    use Data\MatchData;

    const ATTR_ID = 'id';
    const ATTR_NAME = 'name';
    const ATTR_TEAM_1_SCORE = 'team1Score';
    const ATTR_TEAM_2_SCORE = 'team2Score';
    const ATTR_CREATED_AT = 'created_at';
    const ATTR_UPDATED_AT = 'updated_at';
    const ATTR_REVISION = 'revision';

    public function getCreatedAtAsIso() : string
    {
        return $this->getCreatedAt()->format('c') ;
    }

    public function join(int $seat, Domain\Account $account) : void
    {
        if (!in_array($seat, range(1, 4))) {
            throw new \InvalidArgumentException(sprintf('invalid seat number: %d', $seat));
        }

        if (!($account instanceof Account)) {
            throw new \InvalidArgumentException(sprintf('Account must be an instance of %s', Account::class));
        }

        if ($this->getPlayer($seat) !== null) {
            throw InvalidMatchJoinException::seatAlreadyTaken();
        }

        $this->setPlayer($seat, $account);
    }

    public function leave(int $seat, Domain\Account $account) : void
    {
        if (!in_array($seat, range(1, 4))) {
            throw new \InvalidArgumentException(sprintf('invalid seat number: %d', $seat));
        }

        if (!($account === null || $account instanceof Account)) {
            throw new \InvalidArgumentException(sprintf('Account must be an instance of %s', Account::class));
        }

        $currentSeatOwner = $this->getPlayer($seat);

        if ($currentSeatOwner === null) {
            throw InvalidMatchLeaveException::seatAlreadyEmpty();
        }

        if ($currentSeatOwner->getId() !== $account->getId()) {
            throw InvalidMatchLeaveException::seatTakenByOther();
        }

        $this->setPlayer($seat, null);
    }

    public function increaseRevision() : void
    {
        $revision = $this->getRevision();
        $this->setRevision($revision === null ? 1 : $revision + 1);
    }

    public function canStart() : bool
    {
        foreach ($this->getPlayers() as $player) {
            if ($player === null) {
                return false;
            }
        }

        return true;
    }
}
