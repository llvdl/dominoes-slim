<?php

namespace Llvdl\Action\Account;

use Llvdl\Domain\Command\LogOutCommand;
use Psr\Http\Message\ResponseInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;

class LogOutAction
{
    public function __invoke(
        Request $request,
        Response $response,
        LogOutCommand $logOutCommand,
        Messages $messages
    ) : ResponseInterface {
        $logOutCommand();

        $messages->addMessage('success', 'You are now logged out.');

        return $response->withRedirect('/');
    }
}
