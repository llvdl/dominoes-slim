<?php

use Llvdl\Action\Test\LogInAsAction;

/** @var \Slim\App $app */
$app->get('/log-in-as/{account_id}', LogInAsAction::class);
