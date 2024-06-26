<?php

$capsule->addConnection([
    'driver' => $config['database']['driver'],
    'port' => $config['database']['port'],
    'host' => $config['database']['host'],
    'database' => $config['database']['name'],
    'username' => $config['database']['user'],
    'password' => $config['database']['pass'],
    'charset' => $config['database']['charset'],
    'collation' => $config['database']['collation'],
    'prefix' => $config['database']['prefix'],
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
