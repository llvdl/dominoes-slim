<?php

namespace Llvdl\Action\Api;

use Llvdl\Domain\MatchRepository;
use Llvdl\Responder\JsonResponder;
use Slim\Http\Request;
use Slim\Http\Response;

class MatchIndexAction
{
    public function __invoke(
        Request $request,
        Response $response,
        MatchRepository $matchRepository,
        JsonResponder $jsonResponder
    ) {
        $matches = $matchRepository->findAll();
        return $jsonResponder($request, $response, $matches);
    }
}
