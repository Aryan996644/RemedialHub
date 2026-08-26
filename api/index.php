<?php

// Ensure /tmp directory structure exists for serverless runtime
$dirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap',
    '/tmp/bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Clean up any empty-string environment variables from Vercel so Laravel fallback defaults trigger
foreach ($_ENV as $k => $v) {
    if (is_string($v) && trim($v) === '') {
        unset($_ENV[$k]);
        putenv($k);
    }
}
foreach ($_SERVER as $k => $v) {
    if (is_string($v) && trim($v) === '') {
        unset($_SERVER[$k]);
        putenv($k);
    }
}

// Ensure essential serverless configuration
$defaults = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'true',
    'APP_STORAGE' => '/tmp/storage',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'APP_CONFIG_CACHE' => '/tmp/bootstrap/cache/config.php',
    'APP_EVENTS_CACHE' => '/tmp/bootstrap/cache/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/bootstrap/cache/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_DRIVER' => 'cookie',
    'CACHE_STORE' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'DB_CONNECTION' => 'sqlite',
    'APP_MAINTENANCE_DRIVER' => 'file',
    'MAIL_MAILER' => 'log'
];

foreach ($defaults as $key => $val) {
    if (empty($_ENV[$key]) || trim((string)$_ENV[$key]) === '') {
        putenv("$key=$val");
        $_ENV[$key] = $val;
        $_SERVER[$key] = $val;
    }
}

$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Forward to public/index.php
require __DIR__ . '/../public/index.php';
