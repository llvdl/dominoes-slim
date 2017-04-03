<?php

namespace Llvdl\Domain\Impl;

use Llvdl\Domain;
use Jenssegers\Mongodb\Eloquent\Model;
use Llvdl\Domain\Exception\MatchStartException;
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
    const ATTR_STATE = 'state';
    const ATTR_REVISION = 'revision';
    const ATTR_PLAYER_1 = 'player1';
    const ATTR_PLAYER_2 = 'player2';
    const ATTR_PLAYER_3 = 'player3';
    const ATTR_PLAYER_4 = 'player4';

    public function getCreatedAtAsIso() : string
    {
        return $this->getCreatedAt()->format('c') ;
    }

    public function join(int $seat, Domain\Account $account) : void
    {
        $this->assertValidSeatNumber($seat);
        $this->assertImplAccount($account);

        if ($this->getPlayer($seat) !== null) {
            throw InvalidMatchJoinException::seatAlreadyTaken();
        }

        $this->setPlayer($seat, $account);
    }

    public function leave(int $seat, Domain\Account $account) : void
    {
        $this->assertValidSeatNumber($seat);
        $this->assertImplAccount($account);

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

    public function canStart(?Domain\Account $account) : bool
    {
        if ($account === null) {
            return false;
        }

        if (!$this->getState()->canStart()) {
            return false;
        }

        $isOneOfPlayers = false;
        $isAtLeastOneSeatEmpty = false;

        foreach ($this->getPlayers() as $player) {
            $isAtLeastOneSeatEmpty = $isAtLeastOneSeatEmpty || ($player === null);
            $isOneOfPlayers = $isOneOfPlayers || ($player && $player->getId() === $account->getId());
        }

        return !$isAtLeastOneSeatEmpty && $isOneOfPlayers;
    }

    public function start(Domain\Account $account) : void
    {
        $this->assertImplAccount($account);

        if (!$this->canStart($account)) {
            throw MatchStartException::cantStart();
        }

        $this->setState($this->getState()->moveToStarted());
    }

    private function assertValidSeatNumber(int $seat) : void
    {
        if (!in_array($seat, range(1, 4))) {
            throw new \InvalidArgumentException(sprintf('invalid seat number: %d', $seat));
        }
    }

    private function assertImplAccount(Domain\Account $account) : void
    {
        if (!($account === null || $account instanceof Account)) {
            throw new \InvalidArgumentException(sprintf('Account must be an instance of %s', Account::class));
        }
    }
}
