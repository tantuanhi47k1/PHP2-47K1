<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/app/core/bootstrap.php';

$router = new Router();
$router->dispatch($_SERVER["REQUEST_URI"]);