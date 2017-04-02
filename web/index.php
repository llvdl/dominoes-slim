<?php
use Tracy\Debugger;

// Dominoes Again!
// author: Lennaert van der Linden

require_once __DIR__ . '/../vendor/autoload.php';

// RunTracy\Helpers\Profiler\Profiler::enable();
// RunTracy\Helpers\Profiler\Profiler::start('request');

Debugger::enable(Debugger::DEVELOPMENT, __DIR__ . '/.');

RunTracy\Helpers\Profiler\Profiler::start('c3');
include '../c3.php';
RunTracy\Helpers\Profiler\Profiler::finish('c3');

/** @var Slim\App $app */
// RunTracy\Helpers\Profiler\Profiler::start('bootstrap');
$app = require_once __DIR__ . '/../app/bootstrap.php';
// RunTracy\Helpers\Profiler\Profiler::finish('bootstrap');

// Front controller
// RunTracy\Helpers\Profiler\Profiler::start('app_run');
$app->run();
// RunTracy\Helpers\Profiler\Profiler::finish('app_run');

// RunTracy\Helpers\Profiler\Profiler::finish('request');
