<?php

namespace Llvdl\Domain\Impl\Data;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Llvdl\Domain\Impl;
use Llvdl\Domain;

trait MatchData
{
    public function getId() : string
    {
        return $this->{self::ATTR_ID};
    }

    public function getName() : string
    {
        return $this->{self::ATTR_NAME};
    }

    public function setName(string $name)
    {
        $this->{self::ATTR_NAME} = $name;
    }

    public function getTeam1Score() : ?int
    {
        return $this->{self::ATTR_TEAM_1_SCORE};
    }

    public function getTeam2Score() : ?int
    {
        return $this->{self::ATTR_TEAM_2_SCORE};
    }

    public function getGames() : array
    {
        return $this->games();
    }

    public function games()
    {
        return $this->embedsMany(Game::class);
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->{self::ATTR_CREATED_AT};
    }

    public function player1() : BelongsTo
    {
        return $this->belongsTo(Impl\Account::class);
    }

    public function player2() : BelongsTo
    {
        return $this->belongsTo(Impl\Account::class);
    }

    public function player3() : BelongsTo
    {
        return $this->belongsTo(Impl\Account::class);
    }

    public function player4() : BelongsTo
    {
        return $this->belongsTo(Impl\Account::class);
    }

    public function getRevision() : ?int
    {
        return $this->{self::ATTR_REVISION};
    }

    private function setRevision(int $revision) : void
    {
        $this->{self::ATTR_REVISION} = $revision;
    }

    private function getPlayer(int $seat) : ?Domain\Account
    {
        $this->assertValidSeat($seat);

        return $this->{'player' . $seat};
    }

    private function setPlayer(int $seat, ?Domain\Account $account) : void
    {
        $this->assertValidSeat($seat);

        if (!($account === null || $account instanceof Impl\Account)) {
            throw new \InvalidArgumentException(sprintf('Account must be an instance of %s', Impl\Account::class));
        }

        /** @var BelongsTo $player */
        $player = $this->{'player' . $seat}();

        if ($account === null) {
            $player->dissociate();
        } else {
            $player->associate($account);
        }
    }

    private function assertValidSeat(int $seat) : void
    {
        if (!in_array($seat, range(1, 4))) {
            throw new \InvalidArgumentException(sprintf('invalid seat number: %d', $seat));
        }
    }

    /**
     * @return Domain\Account[]
     */
    public function getPlayers() : array
    {
        return [
            '1' => $this->player1,
            '2' => $this->player2,
            '3' => $this->player3,
            '4' => $this->player4
        ];
    }
}
