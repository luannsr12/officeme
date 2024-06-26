<?php

declare(strict_types=1);

// App
!defined('IS_DEBUG') ? define("IS_DEBUG", true) : NULL;
!defined('IS_LOCAL') ? define("IS_LOCAL", true) : NULL;
!defined('APP_NAME') ? define("APP_NAME", "Office Me") : NULL;
!defined('APP_URL') ? define("APP_URL", "http://localhost.test") : NULL;
!defined('TIME_ZONE') ? define("TIME_ZONE", "America/Sao_Paulo") : NULL;
!defined('CURRENCY_TYPE') ? define("CURRENCY_TYPE", "BRL") : NULL;
!defined('CURRENCY_LOCALE') ? define("CURRENCY_LOCALE", "pt-BR") : NULL;
!defined('CURRENCY_SIMBOL') ? define("CURRENCY_SIMBOL", "R$") : NULL;

date_default_timezone_set(TIME_ZONE);

// Sys
!defined('BASEDIR') ? define("BASEDIR", __DIR__) : NULL;
!defined('SYS_OS') ? define("SYS_OS", strtoupper(substr(PHP_OS, 0, 3))) : NULL;
!defined('PATH') ? define("PATH", __DIR__) : NULL;

return [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'name' => 'jobs_balancebet',
        'user' => 'root',
        'pass' => '',
        'port' => '3306',
        'charset' => 'utf8mb4',
        'prefix' => '',
        'collation' => 'utf8mb4_general_ci'
    ],
    'currentDatabaseEnv' => 'development'
];