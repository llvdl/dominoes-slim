<?php

namespace Llvdl\Domain;

interface Account
{
    const ROLE_PLAYER = 'player';

    public function getId() : string;
    public function getName() : string;
    public function getEmail() : string;
    public function setPassword(string $plainPassword) : void;
    public function verifyPassword(string $plainPassword) : bool;
    public function getCreatedAt() : \DateTime;
    public function activate();
    public function isActive() : bool;
}
