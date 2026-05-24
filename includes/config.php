<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$baseUrl = dirname($scriptName);
$baseUrl = preg_replace('#/pages$#', '', $baseUrl);
$baseUrl = rtrim($baseUrl, '/');
define('BASE_URL', $baseUrl);
?>