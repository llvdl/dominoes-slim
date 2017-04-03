<?php

namespace Llvdl\Domain;

interface Match
{
    public function getId() : string;
    public function getName() : string;
    public function setName(string $name);
    /** @return Game[] */
    public function getGames() : array;
    /** @return Account[] */
    public function getPlayers() : array;
    public function getCreatedAtAsIso() : string;

    public function join(int $seat, Account $account) : void;
    public function leave(int $seat, Account $account) : void;

    public function getRevision() : ?int;

    public function canStart(?Account $account) : bool;
    public function start(Account $account) : void;
}
