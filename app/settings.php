<?php

$settings = [
    'settings.displayErrorDetails' => true,
    'settings.addContentLengthHeader' => false,
    'settings.mongodb' =>  [
        'driver'   => 'mongodb',
        'host'     => 'localhost',
        'port'     => 27017,
        'database' => 'dominoes_again',
        'username' => '',
        'password' => '',
        'options' => [
            'database' => 'admin' // sets the authentication database required by mongo 3
        ]
    ],
    'settings.view' => [
        'path' => __DIR__ . '/views',
        'global_data' => [

        ]
    ],
    'settings.tracy' => [
        'showPhpInfoPanel' => 1,
        'showSlimRouterPanel' => 1,
        'showSlimEnvironmentPanel' => 1,
        'showSlimRequestPanel' => 1,
        'showSlimResponsePanel' => 1,
        'showSlimContainer' => 1,
        'showEloquentORMPanel' => 0,
        'showTwigPanel' => 0,
        'showIdiormPanel' => 0,// > 0 mean you enable logging
        // but show or not panel you decide in browser in panel selector
        'showDoctrinePanel' => 'em',// here also enable logging and you must enter your Doctrine container name
        // and also as above show or not panel you decide in browser in panel selector
        'showProfilerPanel' => 0,
        'showVendorVersionsPanel' => 0,
        'showXDebugHelper' => 0,
        'showIncludedFiles' => 0,
        'showConsolePanel' => 0,
        'configs' => [
            // XDebugger IDE key
            'XDebugHelperIDEKey' => 'PHPSTORM',
            'ConsoleNoLogin' => 0,
            'ProfilerPanel' => [
                // Memory usage 'primaryValue' set as Profiler::enable() or Profiler::enable(1)
    //                    'primaryValue' =>                   'effective',    // or 'absolute'
                'show' => [
                    'memoryUsageChart' => 1, // or false
                    'shortProfiles' => true, // or false
                    'timeLines' => true // or false
                ]
            ]
        ]
    ]
];

$env = getenv('APP_ENV');
if ($env !== false) {
    $settings = array_merge(
        $settings,
        require __DIR__ . '/settings.' . $env . '.php'
    );
}

return $settings;
