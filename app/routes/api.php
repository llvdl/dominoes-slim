<?php

use Llvdl\Action\Api\MatchIndexAction;
use Llvdl\Action\Api\MatchDetailAction;

/** @var Slim\App $app */
$app->get('/api/match', MatchIndexAction::class);

$app->get('/api/match/{matchId}', MatchDetailAction::class);
