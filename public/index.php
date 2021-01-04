<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
$env = getenv('ENV');
if ($env === false) {
    require_once __DIR__ . '/../config/debug.php';
    require_once __DIR__ . '/../config/db.php';
}
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/routing.php';
