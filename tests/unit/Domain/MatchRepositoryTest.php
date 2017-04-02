<?php

namespace Llvdl\Domain;

use Llvdl\Domain;

class MatchRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @test
     */
    public function whenSavingAnInstanceOfImplMatchMustBeGiven()
    {
        $match = $this->createMock(Domain\Match::class);
        $repository = new MatchRepository();

        $this->expectException(\InvalidArgumentException::class);

        $repository->save($match);
    }
}
