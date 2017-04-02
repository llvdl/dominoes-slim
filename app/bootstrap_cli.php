<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(array_merge(
    include __DIR__ . '/settings.php',
    include __DIR__ . '/dependencies.php'
));
$container = $containerBuilder->build();

$capsule = $container->get(Capsule::class);

return $container;
