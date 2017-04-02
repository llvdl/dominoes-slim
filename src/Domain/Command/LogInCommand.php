<?php

namespace Llvdl\Domain\Command;

use Llvdl\Domain\AccountRepository;
use Llvdl\Service\AccountSwitcher;
use Llvdl\Domain\Account;

class LogInCommand
{
    /** @var AccountRepository */
    private $accountRepository;

    /** @var AccountSwitcher */
    private $accountSwitcher;

    public function __construct(AccountRepository $accountRepository, AccountSwitcher $accountSwitcher)
    {
        $this->accountRepository = $accountRepository;
        $this->accountSwitcher = $accountSwitcher;
    }

    public function __invoke(string $name, string $password) : void
    {
        /** @var Account $account */
        $account = $this->accountRepository->findByName($name);

        if ($account && $account->verifyPassword($password)) {
            $this->accountSwitcher->switchTo($account);
        }
    }
}
