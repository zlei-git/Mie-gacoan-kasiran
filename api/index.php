<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Ensure essential environment variables for Vercel
putenv("APP_KEY=base64:oyO9ojD/U2iNroCF0BHkP+U5TG0ULjMuMkQ5Mt7hon8=");
$_ENV['APP_KEY'] = 'base64:oyO9ojD/U2iNroCF0BHkP+U5TG0ULjMuMkQ5Mt7hon8=';
$_SERVER['APP_KEY'] = 'base64:oyO9ojD/U2iNroCF0BHkP+U5TG0ULjMuMkQ5Mt7hon8=';

putenv("APP_ENV=production");
putenv("APP_DEBUG=true");
putenv("CACHE_STORE=array");
putenv("SESSION_DRIVER=cookie");
putenv("LOG_CHANNEL=stderr");

$tmpStorage = '/tmp/storage';
$dirs = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/logs'
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

$targetDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';
if (!file_exists($targetDb) && file_exists($sourceDb)) {
    @copy($sourceDb, $targetDb);
}

putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE={$targetDb}");
putenv("VIEW_COMPILED_PATH={$tmpStorage}/framework/views");

$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $targetDb;
$_SERVER['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_DATABASE'] = $targetDb;

try {
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        echo "<h1>Vendor directory is missing on serverless environment.</h1>";
        exit;
    }
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>Server Error: " . htmlspecialchars($e->getMessage()) . "</h1>";
    echo "<p><b>File:</b> " . htmlspecialchars($e->getFile()) . " on line " . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
