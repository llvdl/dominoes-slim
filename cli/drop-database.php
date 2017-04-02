<?php
use Llvdl\Migration\MigrationService;
use Interop\Container\ContainerInterface;
use MongoDB\Database;
use Psr\Log\LoggerInterface;

/** @var ContainerInterface $container */
$container = require_once __DIR__ . '/../app/bootstrap_cli.php';

/** @var Database $database */
$database = $container->get(Database::class);
$database->drop();

$container->get(LoggerInterface::class)->info('Dropped the database.');
