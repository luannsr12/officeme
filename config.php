<?php

declare(strict_types = 1);

// App
!defined('IS_DEBUG') ?   define("IS_DEBUG", true) : NULL;
!defined('IS_LOCAL') ?   define("IS_LOCAL", true) : NULL;
!defined('APP_NAME') ?   define("APP_NAME", "Bet Balance") : NULL;
!defined('APP_URL') ?    define("APP_URL", "http://balancebet.test") : NULL;
!defined('TIME_ZONE') ?  define("TIME_ZONE", "America/Sao_Paulo") : NULL;
!defined('CURRENCY_TYPE') ?  define("CURRENCY_TYPE", "BRL") : NULL;
!defined('CURRENCY_LOCALE') ?  define("CURRENCY_LOCALE", "pt-BR") : NULL;
!defined('CURRENCY_SIMBOL') ?  define("CURRENCY_SIMBOL", "R$") : NULL;

// Api Whatsapp settings
!defined('TOKEN_ADMIN') ?  define('TOKEN_ADMIN', '1234ABCD') : NULL;
!defined('ENDPOINT_API') ? define('ENDPOINT_API', 'http://whatsapp.gestorlite.com/') : NULL;
!defined('WEBHOOK_PREFIX') ? define('WEBHOOK_PREFIX', 'https://c583-45-71-141-215.ngrok-free.app/workspace/jobs/bottelegramphp') : NULL;

date_default_timezone_set(TIME_ZONE);

// Sys
!defined('BASEDIR') ?    define("BASEDIR", __DIR__) : NULL;
!defined('SYS_OS') ?     define("SYS_OS", strtoupper(substr(PHP_OS, 0, 3))) : NULL;
!defined('QUEUE_FILE') ? define("QUEUE_FILE", "queue.php") : NULL;
!defined('CRON_FILE') ?  define("CRON_FILE", "cron.php") : NULL;
!defined('QUEUE_TIME') ? define("QUEUE_TIME", 5) : NULL;
!defined('CRON_TIME') ?  define("CRON_TIME", 60) : NULL;
!defined('PATH') ?       define("PATH", __DIR__) : NULL;

// Token consume queue
!defined('TOKEN_QUEUE') ? define('TOKEN_QUEUE', '1234') : NULL;

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