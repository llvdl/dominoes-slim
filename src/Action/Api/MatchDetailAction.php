<?php

namespace Llvdl\Action\Api;

use Llvdl\Domain\MatchRepository;
use Llvdl\Responder\JsonResponder;
use Llvdl\Responder\JsonNotFoundResponder;
use Llvdl\Service\AccountSwitcher;
use Slim\Http\Request;
use Slim\Http\Response;

class MatchDetailAction
{
    public function __invoke(
        Request $request,
        Response $response,
        MatchRepository $matchRepository,
        JsonResponder $jsonResponder,
        JsonNotFoundResponder $notFoundResponder,
        AccountSwitcher $accountSwitcher,
        string $matchId
    ) {
        /** @var \Llvdl\Domain\Match $match */
        $match = $matchRepository->findById($matchId);

        if ($match === null) {
            return $notFoundResponder($request, $response);
        }

        $data = [
            'match' => $match,
            'can_start' => $match->canStart($accountSwitcher->getCurrentAccount())
        ];

        return $jsonResponder($request, $response, $data);
    }
}
