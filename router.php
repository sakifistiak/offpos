<?php
// Router for PHP built-in web server to mimic Apache mod_rewrite
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the file or directory exists locally, serve it directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Otherwise, route all requests through index.php
$_SERVER['SCRIPT_NAME'] = '/index.php';
include_once __DIR__ . '/index.php';
