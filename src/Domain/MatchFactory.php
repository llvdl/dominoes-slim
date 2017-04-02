<?php

namespace Llvdl\Domain;

class MatchFactory
{
    public function createMatch(string $name) : Match
    {
        $match = new Impl\Match();
        $match->setName($name);

        return $match;
    }
}
