<?php

namespace Llvdl\Domain\Impl;

use Llvdl\Domain;
use Jenssegers\Mongodb\Eloquent\Model;

class Game extends Model implements Domain\Game
{
    const ATTR_TURN = 'turn';

    private $turn = 1;

    public function getTurn() : int
    {
        return $this->{self::ATTR_TURN};
    }

    public function getPlays() : array
    {
        return $this->plays();
    }

    public function plays()
    {
        return $this->embedsMany(Play::class);
    }
}
