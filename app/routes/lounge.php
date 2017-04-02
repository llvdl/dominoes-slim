<?php

use Llvdl\Action\Lounge\HomeAction;
use Llvdl\Action\Lounge\MatchDetailAction;
use Llvdl\Action\Lounge\CreateMatchAction;
use Llvdl\Action\Lounge\MatchOverviewAction;
use Llvdl\Action\Test\LogInAsAction;
use Llvdl\Domain\Account;
use Llvdl\Middleware\Authorization\Authorizer;
use Llvdl\Middleware\Validation\CreateMatchValidator;
use Llvdl\Service\AccountSwitcher;

/** @var Slim\App $app */

/** @var Slim\App $this */
$app->get('/', HomeAction::class);

$app->group('/', function() {
    $this
        ->map(['GET', 'POST'], 'create-match', CreateMatchAction::class)
        ->add(new CreateMatchValidator());

    $this
        ->map(['GET', 'POST'], 'match/{matchId}', MatchDetailAction::class);

    $this
        ->get('match', MatchOverviewAction::class);
});//->add(new Authorizer($app->getContainer()->get(AccountSwitcher::class), [Account::ROLE_PLAYER]));
