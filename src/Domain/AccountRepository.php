<?php

namespace Llvdl\Domain;

use Llvdl\Domain\Impl;

class AccountRepository
{
    public function findById(string $id) : ?Account
    {
        return Impl\Account::query()
            ->where(Impl\Account::ATTR_ID, $id)
            ->first();
    }

    public function getNameUsageCount(string $name) : int
    {
        return Impl\Account::query()
            ->where('name', $name)
            ->count();
    }

    public function findByName(string $name) : ?Account
    {
        return Impl\Account::query()
            ->where(Impl\Account::ATTR_NAME, $name)
            ->where(Impl\Account::ATTR_ACTIVE, true)
            ->first();
    }


    public function save(Account $account) : void
    {
        if (!($account instanceof Impl\Account)) {
            throw new \InvalidArgumentException(sprintf('Account must be an instance of %s', Impl\Account::class));
        }

        /** @var Impl\Account $account */
        $account->save();
    }

    public function delete(Account $account) : void
    {
        if (!($account instanceof Impl\Account)) {
            throw new \InvalidArgumentException(sprintf('Account must be an instance of %s', Impl\Account::class));
        }

        /** @var Impl\Account $account */
        $account->delete();
    }
}
