<?php

namespace Llvdl\Domain;

class AccountFactory
{
    public function createAccount(string $name, string $email, string $password) : \Llvdl\Domain\Account
    {
        $account = new Impl\Account();
        $account->setName($name);
        $account->setEmail($email);
        $account->setPassword($password);
        $account->setActive(false);

        return $account;
    }
}
