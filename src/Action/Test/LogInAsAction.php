<?php

namespace Llvdl\Action\Test;

use Llvdl\Domain\AccountRepository;
use Llvdl\Service\AccountSwitcher;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class LogInAsAction
{
    public function __invoke(
        Request $request,
        Response $response,
        string $account_id,
        AccountRepository $accountRepository,
        AccountSwitcher $accountSwitcher
    ) : ResponseInterface {
        $account = $accountRepository->findById($account_id);

        if ($account === null) {
            return $this->getErrorResponse($response, sprintf('Error loading account with id "%s"', $account_id));
        }

        $accountSwitcher->switchTo($account);

        return $this->getOkResponse(
            $response,
            sprintf('Logged in as %s / "%s"', $account->getId(), $account->getName())
        );
    }

    private function getErrorResponse(Response $response, string $message) : Response
    {
        $response->write('<div style="padding: 1em; background-color: red; color: white;">');
        $response->write('<b>Error</b>: ' . htmlspecialchars($message));
        $response->write('</div>');

        $response = $response->withStatus(400);

        return $response;
    }

    private function getOkResponse(Response $response, $message) : Response
    {
        $response->write('<div style="padding: 1em; background-color: purple; color: white;">');
        $response->write(htmlspecialchars($message));
        $response->write('</div>');

        return $response;
    }
}
