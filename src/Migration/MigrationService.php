<?php

namespace Llvdl\Migration;

use MongoDB;
use MongoDB\Database;
use Psr\Log\LoggerInterface;

class MigrationService
{

    /** @var string */
    private $path;

    /** @var Database */
    private $database;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(Database $database, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->database = $database;

        $this->path = __DIR__ . '/../../app/migrations';
    }

    public function migrateUp()
    {
        $ranCount = 0;
        $migrations = $this->getMigrations();
        foreach ($migrations as $migration) {
            if (!$this->hasRun($migration)) {
                $this->run($migration);
                ++$ranCount;
            }
        }

        $this->logger->info(sprintf('Ran %d migration(s).', $ranCount));
    }

    /**
     * Get a sorted list of all available migrations.
     *
     * @return string[] path names of migration files
     */
    private function getMigrations() : array
    {
        $files = [];
        foreach (new \DirectoryIterator($this->path) as $fileInfo) {
            /** @var \DirectoryIterator $fileInfo */
            if ($fileInfo->isDot()) {
                continue;
            }

            if (preg_match('/^Version\d{4}\d{2}\d{2}\d{2}\d{2}\d{2}\.php$/', $fileInfo->getFilename())) {
                $files[] = [
                    'pathName' => $fileInfo->getPathname(),
                    'className' => $fileInfo->getBasename('.php'),
                    'version' => preg_replace('/^Version/', '', $fileInfo->getBasename('.php'))
                ];
            }
        }

        sort($files);

        return $files;
    }

    private function hasRun(array $migration)
    {
        $collection = $this->database->selectCollection('database_migrations');
        $item = $collection->findOne(['version' => $migration['version']]);

        return $item !== null;
    }

    private function run(array $migration)
    {
        $this->logger->notice(sprintf('Running migration %s', $migration['version']));

        require $migration['pathName'];
        $className = 'Migration\\' . $migration['className'];
        /** @var Migration $migrationCommand */
        $migrationCommand = new $className($this->logger);

        $migrationCommand->up($this->database);
        $this->markAsRan($migration);
    }

    private function markAsRan(array $migration)
    {
        $collection = $this->database->selectCollection('database_migrations');
        $collection->insertOne(['version' => $migration['version']]);
    }
}
