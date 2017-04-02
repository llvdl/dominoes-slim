<?php

namespace Llvdl\Service;

use Llvdl\Domain\Account;
use Aura\Session\Session;
use Llvdl\Domain\AccountRepository;

class AccountSwitcher
{
    /** @var Session */
    private $session;

    /** AccountRepository */
    private $accountRepository;

    public function __construct(Session $session, AccountRepository $accountRepository)
    {
        $this->session = $session;
        $this->accountRepository = $accountRepository;
    }

    public function switchTo(?Account $account) : void
    {
        $segment = $this->session->getSegment(self::class);
        $segment->set('account_id', $account ? $account->getId() : null);
    }

    public function getCurrentAccount() : ?Account
    {
        $segment = $this->session->getSegment(self::class);

        $accountId = $segment->get('account_id');

        return $accountId === null ? null : $this->accountRepository->findById($accountId);
    }

    public function isLoggedInAs(string $name) : bool
    {
        $currentAccount = $this->getCurrentAccount();

        return $currentAccount ? $currentAccount->getName() === $name : false;
    }
}
