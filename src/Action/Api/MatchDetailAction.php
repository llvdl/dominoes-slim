<?php

namespace Llvdl\Action\Api;

use Llvdl\Domain\MatchRepository;
use Llvdl\Responder\JsonResponder;
use Llvdl\Responder\JsonNotFoundResponder;
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
        string $matchId
    ) {
        /** @var \Llvdl\Domain\Match $match */
        $match = $matchRepository->findById($matchId);

        if ($match === null) {
            return $notFoundResponder($request, $response);
        }

        return $jsonResponder($request, $response, $match);
    }
}
