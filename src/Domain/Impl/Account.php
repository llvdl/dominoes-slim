<?php

namespace Llvdl\Domain\Impl;

use Llvdl\Domain as Domain;
use Jenssegers\Mongodb\Eloquent\Model;

class Account extends Model implements Domain\Account
{
    const ATTR_ID = '_id';
    const ATTR_NAME = 'name';
    const ATTR_EMAIL = 'email';
    const ATTR_PASSWORD_HASH = 'password_hash';
    const ATTR_CREATED_AT = 'created_at';
    const ATTR_ACTIVE = 'is_active';

    use Data\AccountData;

    public function setPassword(string $password) : void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->{self::ATTR_PASSWORD_HASH} = $hash;
    }

    public function verifyPassword(string $password) : bool
    {
        return password_verify($password, $this->{self::ATTR_PASSWORD_HASH});
    }

    public function activate()
    {
        $this->setActive(true);
    }
}
