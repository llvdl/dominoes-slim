<?php

namespace Llvdl\Domain\Command;

use Llvdl\Domain\Account;
use Llvdl\Domain\AccountFactory;
use Llvdl\Domain\AccountRepository;
use Llvdl\Domain\Exception\AccountNameInUseException;

class CreateAccountCommand
{
    /** @var AccountFactory */
    private $accountFactory;

    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountFactory $accountFactory, AccountRepository $accountRepository)
    {
        $this->accountFactory = $accountFactory;
        $this->accountRepository = $accountRepository;
    }

    public function __invoke($name, $email, $password) : void
    {
        $account = $this->accountFactory->createAccount($name, $email, $password);
        $this->accountRepository->save($account);

        try {
            $this->validate($account);

            $account->activate();
            $this->accountRepository->save($account);
        } catch (\Exception $e) {
            $this->accountRepository->delete($account);
            throw $e;
        }
    }

    /** @throws AccountNameInUseException */
    private function validate(Account $account) : void
    {
        $count = $this->accountRepository->getNameUsageCount($account->getName());
        if ($count > 1) {
            throw new AccountNameInUseException($account->getName());
        }
    }
}
