<?php

namespace Llvdl\Migration;

use MongoDB\Database;
use Psr\Log\LoggerInterface;

/**
 * Base Migration class
 */
abstract class Migration
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function getLogger() : LoggerInterface
    {
        return $this->logger;
    }

    abstract public function up(Database $database);
}
