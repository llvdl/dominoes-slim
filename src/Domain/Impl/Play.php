<?php

namespace Llvdl\Domain\Impl;

use Llvdl\Domain as Domain;
use Jenssegers\Mongodb\Eloquent\Model;

class Play extends Model implements Domain\Play
{
    const ATTR_TYPE = 'type';
    const ATTR_POSITION = 'position';
    const ATTR_SIDE = 'side';
    const ATTR_STONE = 'stone';

    public function getType() : string
    {
        return $this->{self::ATTR_TYPE};
    }

    public function getPosition() : string
    {
        return $this->{self::ATTR_POSITION};
    }

    public function getSide() : string
    {
        return $this->{self::ATTR_SIDE};
    }

    public function getStone() : int
    {
        return $this->{self::ATTR_STONE};
    }

    public static function createMove(string $position, string $side, int $stone)
    {
        $play = new Play();
        $play->{self::ATTR_TYPE} = self::TYPE_MOVE;
        $play->{self::ATTR_POSITION} = $position;
        $play->{self::ATTR_SIDE} = $side;
        $play->{self::ATTR_STONE} = $stone;

        return $play;
    }

    public static function createPass()
    {
        $play = new Play();
        $play->{self::ATTR_TYPE} = self::TYPE_PASS;

        return $play;
    }

    public function isMove() : bool
    {
        return $this->getType() === self::TYPE_MOVE;
    }

    public function isPass() : bool
    {
        return $this->getType() === self::TYPE_PASS;
    }
}
