<?php

return [
    'settings.mongodb' => [
        'driver'   => 'mongodb',
        'host'     => 'localhost',
        'port'     => 27017,
        'database' => 'dominoes_again_test',
        'username' => '',
        'password' => '',
        'options' => [
            'database' => 'admin' // sets the authentication database required by mongo 3
        ]
    ]
];
