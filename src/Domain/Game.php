<?php

namespace Llvdl\Domain;

interface Game
{
    public function getTurn() : int;

    /** @return Play[] */
    public function getPlays() : array;
}
