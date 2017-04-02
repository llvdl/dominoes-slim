<?php

namespace Domain;

use Llvdl\Domain\Account;
use Llvdl\Domain\AccountRepository;

class AccountRepositoryTest extends \Codeception\Test\Unit
{
    /** @var AccountRepository */
    private $repository;

    /** @var Account */
    private $mockAccount;

    protected function _before()
    {
        $this->repository = new AccountRepository();
        $this->mockAccount = $this->createMock(Account::class);
    }

    /**
     * @test
     */
    public function testWhenSavingAnAccountTheRepositoryMustByPassedInImplAccount()
    {
        $this->expectException(\InvalidArgumentException::class);

        // should throw invalid argument exception, because the mock does not extend Domain\Impl\Account
        $this->repository->save($this->mockAccount);
    }

    /**
     * @test
     */
    public function testWhenDeletingAnAccountTheRepositoryMustByPassedInImplAccount()
    {
        $this->expectException(\InvalidArgumentException::class);

        // should throw invalid argument exception, because the mock does not extend Domain\Impl\Account
        $this->repository->delete($this->mockAccount);
    }
}
