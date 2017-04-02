<?php

namespace Llvdl\Action\Lounge;

use Llvdl\Domain\MatchRepository;
use Llvdl\Domain\Exception\InvalidMatchJoinException;
use Llvdl\Domain\Exception\InvalidMatchLeaveException;
use Llvdl\Service\AccountSwitcher;
use Llvdl\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;

class MatchDetailAction
{
    /** @var callable */
    private $notFoundHandler;

    public function __construct(callable $notFoundHandler)
    {
        $this->notFoundHandler = $notFoundHandler;
    }

    public function __invoke(
        Request $request,
        Response $response,
        MatchRepository $matchRepository,
        AccountSwitcher $accountSwitcher,
        Messages $messages,
        ViewInterface $view,
        string $matchId
    ) : ResponseInterface {
        $match = $matchRepository->findById($matchId);
        if ($match === null) {
            $handler = $this->notFoundHandler;
            return $handler($request, $response);
        }

        if ($request->getParsedBody()) {
            $data = $request->getParsedBody();

            try {
                if (isset($data['join'])) {
                    $match->join((int) $data['join'], $accountSwitcher->getCurrentAccount());
                    $matchRepository->save($match);
                } elseif (isset($data['leave'])) {
                    $match->leave((int) $data['leave'], $accountSwitcher->getCurrentAccount());
                    $matchRepository->save($match);
                }
            } catch (InvalidMatchJoinException $e) {
                $messages->addMessage('danger', 'Error joining seat: ' . $e->getMessage());
            } catch (InvalidMatchLeaveException $e) {
                $messages->addMessage('danger', 'Error leaving seat: '. $e->getMessage());
            }

            return $response->withRedirect($request->getUri()->getPath());
        }

        return $response->write($view->render('Lounge/matchDetail.phtml', ['match' => $match]));
    }
}
