<?php
use Llvdl\Migration\MigrationService;
use Interop\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = require_once __DIR__ . '/../app/bootstrap_cli.php';

/** @var MigrationService $migrator */
$migrator = $container->get(MigrationService::class);
$migrator->migrateUp();
