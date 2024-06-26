<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// load composer dependencies
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Configuração da conexão com o banco de dados
$capsule = new Capsule;
$config  = require_once 'config.php';

// Load conenction
require_once 'database/connection.php';

// Load our helpers
require_once 'app/helpers.php';

// Load our custom routes
require_once 'routes/web.php';

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::enableMultiRouteRendering(false);

// Start the routing
echo SimpleRouter::start();