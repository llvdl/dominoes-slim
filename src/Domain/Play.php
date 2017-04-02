<?php

namespace Llvdl\Domain;

interface Play
{
    const TYPE_MOVE = 'play';
    const TYPE_PASS = 'pass';

    const POSITION_START = 'start';
    const POSITION_END = 'end';

    const SIDE_TOP = 'top';
    const SIDE_BOTTOM = 'bottom';

    public function getType() : string;

    public function getPosition() : string;

    public function getSide() : string;

    public function getStone() : int;

    public function isMove() : bool;

    public function isPass() : bool;
}
