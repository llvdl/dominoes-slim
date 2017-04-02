<?php

namespace Llvdl\Domain;

use Llvdl\Domain;
use Llvdl\Domain\Impl;

class MatchRepository
{
    /** @return Match[] */
    public function findAll() : array
    {
        return Impl\Match::all()
            ->sortBy('created_at', SORT_REGULAR, true)
            ->all();
    }

    public function findById($id) : ?Match
    {
        return Impl\Match::query()->find($id);
    }

    public function save(Domain\Match $match) : void
    {
        if (!($match instanceof Impl\Match)) {
            throw new \InvalidArgumentException(
                sprintf('Expected instance of "%s", got "%s"', Impl\Match::class, get_class($match))
            );
        }

        /** @var Impl\Match $match */
        $match->increaseRevision();
        $match->save();
    }
}
