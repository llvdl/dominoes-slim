<?php
use Llvdl\Action\Account\LogInAction;
use Llvdl\Action\Account\LogOutAction;
use Llvdl\Action\Lounge\CreateAccountAction;
use Llvdl\Domain\AccountRepository;
use Llvdl\Middleware\Validation\LogInValidator;
use Llvdl\Middleware\Validation\CreateAccountValidator;

/** @var Slim\App $app */

$app
    ->map(['GET', 'POST'], '/login', LogInAction::class)
    ->add(LogInValidator::class);

$app
    ->get('/logout', LogOutAction::class);

$app
    ->map(['GET', 'POST'], '/create-account', CreateAccountAction::class)
    ->add(new CreateAccountValidator($app->getContainer()->get(AccountRepository::class)));
