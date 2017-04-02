<?php

namespace Llvdl\Action\Lounge;

use Llvdl\Domain\MatchFactory;
use Llvdl\Domain\MatchRepository;
use Llvdl\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;

class CreateMatchAction
{
    public function __invoke(
        Request $request,
        Response $response,
        MatchFactory $matchFactory,
        MatchRepository $matchRepository,
        Messages $messages,
        ViewInterface $view
    ) : ResponseInterface {
        $errors = $request->getMethod() === 'POST' ? $request->getAttribute('errors') : [];
        $data = $request->getParsedBody();
        if ($request->getMethod() === 'POST' && empty($errors)) {
            $match = $matchFactory->createMatch($data['name']);
            $matchRepository->save($match);

            $messages->addMessage('success', 'Match created');

            return $response->withRedirect(sprintf('/match/%s', $match->getId()));
        }

        return $response->write($view->render('Lounge/createMatch.phtml', [
            'data' => $data,
            'errors' => $errors
        ]));
    }
}
