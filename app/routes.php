<?php

require_once __DIR__ . '/routes/lounge.php';
require_once __DIR__ . '/routes/api.php';
require_once __DIR__ . '/routes/account.php';

$env = getenv('APP_ENV');
if ($env !== false) {
    if (file_exists(__DIR__ . '/routes/' . $env . '.php')) {
        require_once __DIR__ . '/routes/' . $env . '.php';
    }
}
