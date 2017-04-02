<?php

namespace Domain\Impl;

use Llvdl\Domain;
use Llvdl\Domain\Impl;
use Llvdl\Domain\Exception\InvalidMatchJoinException;
use Llvdl\Domain\Exception\InvalidMatchLeaveException;

class AccountRepositoryTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        require_once __DIR__ . '/../../../../app/bootstrap.php';
    }

    /**
     * @test
     * @dataProvider provideInvalidSeatNumbers
     */
    public function mustHaveAValidSeatNumberToJoin($seat) : void
    {
        $account = new Impl\Account();

        // should throw invalid argument exception, because the seat number is invalid
        $this->expectException(\InvalidArgumentException::class);

        $match = new Impl\Match();
        $match->join($seat, $account);
    }

    /**
     * @test
     * @dataProvider provideInvalidSeatNumbers
     */
    public function mustHaveAValidSeatNumberToLeave($seat) : void
    {
        $account = new Impl\Account();

        // should throw invalid argument exception, because the seat number is invalid
        $this->expectException(\InvalidArgumentException::class);

        $match = new Impl\Match();
        $match->leave($seat, $account);
    }

    public function provideInvalidSeatNumbers() : array
    {
        return [
            'negative seat number' => [-1],
            'seat 0 (seat numbers start at 1)' => [0],
            'to high (max is 4)' => [5],
            'way too high (max is 4)' => [10]
        ];
    }

    /**
     * @test
     */
    public function accountMustBeInstanceOfImplAccountToJoin()
    {
        $account = $this->createMock(Domain\Account::class);

        // should throw invalid argument exception, because the seat number is invalid
        $this->expectException(\InvalidArgumentException::class);

        $match = new Impl\Match();
        $match->join(1, $account);
    }

    /**
     * @test
     */
    public function accountMustBeInstanceOfImplAccountToLeave()
    {
        $account = $this->createMock(Domain\Account::class);

        // should throw invalid argument exception, because the seat number is invalid
        $this->expectException(\InvalidArgumentException::class);

        $match = new Impl\Match();
        $match->leave(1, $account);
    }

    /**
     * @test
     */
    public function cannotJoinSeatIfAlreadyTaken()
    {
        $account1 = $this->createMock(Impl\Account::class);
        $account2 = $this->createMock(Impl\Account::class);

        $match = new Impl\Match();
        $match->join(1, $account1);

        $this->expectException(InvalidMatchJoinException::class);

        $match->join(1, $account2);
    }

    /**
     * @test
     */
    public function canUnseatGivenSameAccount()
    {
        $account = new Impl\Account();
            $account->setAttribute(Impl\Account::ATTR_ID, '1');

        $match = new Impl\Match();
        $match->join(1, $account);

        $this->assertSame($account, $match->getPlayers()[1]);

        $match->leave(1, $account);

        $this->assertSame(null, $match->getPlayers()[1]);
    }

    /**
     * @test
     */
    public function cannotUnseatGivenDifferentAccount()
    {
        $account1 = new Impl\Account();
        $account1->setAttribute(Impl\Account::ATTR_ID, '1');
        $account2 = new Impl\Account();
        $account2->setAttribute(Impl\Account::ATTR_ID, '2');

        $match = new Impl\Match();
        $match->join(1, $account1);

        $this->expectException(InvalidMatchLeaveException::class);

        $match->leave(1, $account2);
    }

    /**
     * @test
     */
    public function cannotLeaveAlreadyEmptySeat()
    {
        $account = new Impl\Account();

        $match = new Impl\Match();

        $this->expectException(InvalidMatchLeaveException::class);

        $match->leave(1, $account);
    }

    /**
     * @test
     */
    public function canStartIfAllSeatsAreAssignedToAPlayer()
    {
        $account = new Impl\Account();

        $match = new Impl\Match();
        $this->assertSame(false, $match->canStart());

        $match->join(1, $account);
        $this->assertSame(false, $match->canStart());

        $match->join(2, $account);
        $this->assertSame(false, $match->canStart());

        $match->join(3, $account);
        $this->assertSame(false, $match->canStart());

        $match->join(4, $account);
        $this->assertSame(true, $match->canStart());
    }

    /**
     * @test
     */
    public function itCanIncreaseTheRevision()
    {
        $match = new Impl\Match();

        $this->assertSame(null, $match->getRevision());

        for ($i = 1; $i < 12; ++$i) {
            $match->increaseRevision();
            $this->assertSame($i, $match->getRevision());
        }
    }
}
