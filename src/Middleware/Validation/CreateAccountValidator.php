<?php

namespace Llvdl\Middleware\Validation;

use DavidePastore\Slim\Validation\Validation;
use Llvdl\Domain\AccountRepository;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;

class CreateAccountValidator extends Validation
{
    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;

        $validators = [
            'name' => v::notBlank()->setName('Name'),
            'email' => v::notBlank()->email()->setName('E-mail'),
            'password' => v::notBlank()->setName('Password'),
            'password-repeat' => v::notBlank()->setName('Repeated password')
        ];

        parent::__construct($validators);
    }

    public function __invoke($request, $response, $next)
    {
        $myNext = function (Request $request, Response $response) use ($next) {
            $params = $request->getParams();

            // test if password and repeat password match
            $password = $this->getParam($params, 'password');
            $repeatPassword = $this->getParam($params, 'password-repeat');
            if ($password !== '' && $password !== $repeatPassword) {
                $this->errors['password-repeat'][] = 'Password and repeated password do not match';
                $request = $request->withAttribute($this->errors_name, $this->getErrors());
            }


            return $next($request, $response);
        };

        return parent::__invoke($request, $response, $myNext);
    }

    private function getParam(array $params, $name)
    {
        return array_key_exists($name, $params) ? $params[$name] : null;
    }
}
