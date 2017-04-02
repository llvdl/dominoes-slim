<?php

namespace Migration;

use Llvdl\Migration\Migration;
use MongoDB\Database;

class Version20170212122300 extends Migration
{
    public function up(Database $database)
    {
        $this->getLogger()->notice('Dropping and (re)creating accounts');
        $database->dropCollection('accounts');
        $database->createCollection('accounts', [
            'validator' => [
                '$and' => [
                    'name' => 'string',
                    'pripra' => ['$exists' => true],
                    'email' => 'string',
                    'password_hash' => 'string',
                    'created_at' => 'timestamp',
                    'active' => 'bool'
                ]
            ]
        ]);

        $this->getLogger()->notice('Dropping and (re)creating matches');
        $database->dropCollection('matches');
        $database->createCollection('matches');
    }
}
