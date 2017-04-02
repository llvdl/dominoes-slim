<?php

namespace Llvdl\Domain\Command;

use Llvdl\Service\AccountSwitcher;

class LogOutCommand
{
    /** @var AccountSwitcher */
    private $accountSwitcher;

    public function __construct(AccountSwitcher $accountSwitcher)
    {
        $this->accountSwitcher = $accountSwitcher;
    }

    public function __invoke() : void
    {
        $this->accountSwitcher->switchTo(null);
    }
}
