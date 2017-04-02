<?php

namespace Llvdl\Action\Account;

use Llvdl\Domain\AccountRepository;
use Llvdl\Domain\Command\LogInCommand;
use Llvdl\Responder\Account\LogInResponder;
use Llvdl\Service\AccountSwitcher;
use Llvdl\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;

class LogInAction
{
    public function __invoke(
        Request $request,
        Response $response,
        LogInCommand $logInCommand,
        AccountSwitcher $accountSwitcher,
        ViewInterface $view,
        Messages $messages
    ) : ResponseInterface {
        $errors = $request->getMethod() === 'POST' ? $request->getAttribute('errors') : [];
        $data = $request->getParsedBody();
        if ($request->getMethod() === 'POST' && empty($errors)) {
            $logInCommand($data['name'], $data['password']);

            if ($accountSwitcher->isLoggedInAs($data['name'])) {
                $messages->addMessage('success', 'Login successful');

                return $response->withRedirect('/');
            }

            $messages->addMessageNow('danger', 'Log in failed. Invalid credentials.');
        }

        return $response->write($view->render('Account/logIn.phtml', [
            'data' => $data,
            'errors' => $errors
        ]));
    }
}
