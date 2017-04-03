<?php

namespace Llvdl\Domain\Command;

use Llvdl\Domain\Match;
use Llvdl\Domain\MatchRepository;
use Llvdl\Domain\Account;

class TakeSeatCommand
{
    /** @var MatchRepository */
    private $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function __invoke(Match $match, int $seat, Account $account)
    {
        $match->join($seat, $account);
        $this->matchRepository->save($match);
    }
}
