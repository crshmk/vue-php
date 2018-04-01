<?php

/**
 * The entry point for all requests
 * This is the place to define headers, session_start, ob_start, ini_set, etc.
 */

//header('Content-Type: application/json');

require_once __DIR__ . '/Config/globals.php';

spl_autoload_register(function($class) {
    require_once __DIR__ . str_replace('\\', '/', substr($class, 3)) . '.php';
});

new App\App\App();

exit;
