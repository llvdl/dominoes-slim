<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use DI\Bridge\Slim\App;

use Illuminate\Database\Capsule\Manager as Capsule;
use RunTracy\Middlewares\TracyMiddleware;

session_start();

/** @var App $app */
$app = new class() extends App {
    protected function configureContainer(ContainerBuilder $builder)
    {
        $definitions = array_merge(
            include __DIR__ . '/settings.php',
            include __DIR__ . '/dependencies.php'
        );

        $builder->addDefinitions($definitions);
    }
};
require_once __DIR__ . '/routes.php';

$capsule = $app->getContainer()->get(Capsule::class);

$app->add(new TracyMiddleware($app));

return $app;
