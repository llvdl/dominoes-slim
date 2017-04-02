<?php

namespace Llvdl\Action\Lounge;

use Llvdl\Domain\Command\CreateAccountCommand;
use Llvdl\Domain\Exception\AccountNameInUseException;
use Llvdl\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Flash\Messages;

class CreateAccountAction
{
    public function __invoke(
        Request $request,
        Response $response,
        CreateAccountCommand $createAccountCommand,
        Messages $messages,
        ViewInterface $view
    ) : ResponseInterface {
        $errors = $request->getMethod() === 'POST' ? $request->getAttribute('errors') : [];
        $data = $request->getParsedBody();

        if ($request->getMethod() === 'POST' && empty($errors)) {
            try {
                $createAccountCommand($data['name'], $data['email'], $data['password']);
                $messages->addMessage('success', 'Account created');

                return $response->withRedirect('/');
            } catch (AccountNameInUseException $e) {
                $errors['name'] = ['Account name is already in use.'];
            }
        }

        return $response->write($view->render('Lounge/createAccount.phtml', [
            'data' => $data,
            'errors' => $errors
        ]));
    }
}
