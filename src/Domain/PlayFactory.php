<?php

namespace Llvld\Domain;

use Llvdl\Domain\Play;
use Llvdl\Domain\Impl;

class PlayFactory
{
    public function createPass() : Play
    {
        return Impl\Play::createPass();
    }

    public function createMove(string $position, string $side, int $stone) : Play
    {
        return Impl\Play::createMove($position, $side, $stone);
    }
}
