<?php

// Ensure essential environment variables for Vercel
putenv("APP_KEY=base64:oyO9ojD/U2iNroCF0BHkP+U5TG0ULjMuMkQ5Mt7hon8=");
$_ENV['APP_KEY'] = 'base64:oyO9ojD/U2iNroCF0BHkP+U5TG0ULjMuMkQ5Mt7hon8=';
$_SERVER['APP_KEY'] = 'base64:oyO9ojD/U2iNroCF0BHkP+U5TG0ULjMuMkQ5Mt7hon8=';

putenv("APP_NAME=MieGacoan");
$_ENV['APP_NAME'] = 'MieGacoan';
$_SERVER['APP_NAME'] = 'MieGacoan';

putenv("APP_ENV=production");
putenv("APP_DEBUG=false");
$_ENV['APP_DEBUG'] = 'false';
$_SERVER['APP_DEBUG'] = 'false';
putenv("CACHE_STORE=array");
putenv("SESSION_DRIVER=file");
$_ENV['SESSION_DRIVER'] = 'file';
$_SERVER['SESSION_DRIVER'] = 'file';
putenv("SESSION_LIFETIME=120");
$_ENV['SESSION_LIFETIME'] = '120';
$_SERVER['SESSION_LIFETIME'] = '120';
putenv("SESSION_EXPIRE_ON_CLOSE=false");
$_ENV['SESSION_EXPIRE_ON_CLOSE'] = 'false';
$_SERVER['SESSION_EXPIRE_ON_CLOSE'] = 'false';
putenv("SESSION_SECURE_COOKIE=true");
$_ENV['SESSION_SECURE_COOKIE'] = 'true';
$_SERVER['SESSION_SECURE_COOKIE'] = 'true';
putenv("LOG_CHANNEL=stderr");
putenv("APP_MAINTENANCE_DRIVER=file");
$_ENV['APP_MAINTENANCE_DRIVER'] = 'file';
$_SERVER['APP_MAINTENANCE_DRIVER'] = 'file';
putenv("APP_URL=https://gacoankasir.vercel.app");
$_ENV['APP_URL'] = 'https://gacoankasir.vercel.app';
$_SERVER['APP_URL'] = 'https://gacoankasir.vercel.app';
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = 443;
$_SERVER['HTTP_X_FORWARDED_PROTO'] = 'https';
putenv("VERCEL=1");

$tmpStorage = '/tmp/storage';
$bootstrapDir = $tmpStorage . '/bootstrap';
$bootstrapCache = $bootstrapDir . '/cache';
$dirs = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/logs',
    $bootstrapDir,
    $bootstrapCache
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Copy bootstrap files so $app->useBootstrapPath has providers.php and app.php
foreach (['providers.php', 'app.php'] as $bFile) {
    $src = __DIR__ . '/../bootstrap/' . $bFile;
    $dst = $bootstrapDir . '/' . $bFile;
    if (file_exists($src) && !file_exists($dst)) {
        @copy($src, $dst);
    }
}

// Ensure Laravel points its bootstrap caches to writable /tmp
putenv("APP_SERVICES_CACHE={$bootstrapCache}/services.php");
putenv("APP_PACKAGES_CACHE={$bootstrapCache}/packages.php");
putenv("APP_CONFIG_CACHE={$bootstrapCache}/config.php");
putenv("APP_ROUTES_CACHE={$bootstrapCache}/routes.php");
putenv("APP_EVENTS_CACHE={$bootstrapCache}/events.php");

$_ENV['APP_SERVICES_CACHE'] = "{$bootstrapCache}/services.php";
$_ENV['APP_PACKAGES_CACHE'] = "{$bootstrapCache}/packages.php";
$_ENV['APP_CONFIG_CACHE'] = "{$bootstrapCache}/config.php";
$_ENV['APP_ROUTES_CACHE'] = "{$bootstrapCache}/routes.php";
$_ENV['APP_EVENTS_CACHE'] = "{$bootstrapCache}/events.php";

$_SERVER['APP_SERVICES_CACHE'] = "{$bootstrapCache}/services.php";
$_SERVER['APP_PACKAGES_CACHE'] = "{$bootstrapCache}/packages.php";
$_SERVER['APP_CONFIG_CACHE'] = "{$bootstrapCache}/config.php";
$_SERVER['APP_ROUTES_CACHE'] = "{$bootstrapCache}/routes.php";
$_SERVER['APP_EVENTS_CACHE'] = "{$bootstrapCache}/events.php";

$targetDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';
if (file_exists($sourceDb)) {
    if (!file_exists($targetDb) || filesize($targetDb) !== filesize($sourceDb)) {
        @copy($sourceDb, $targetDb);
        @chmod($targetDb, 0666);
    }
}

putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE={$targetDb}");
putenv("VIEW_COMPILED_PATH={$tmpStorage}/framework/views");

$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $targetDb;
$_SERVER['DB_CONNECTION'] = 'sqlite';
$_SERVER['DB_DATABASE'] = $targetDb;
require __DIR__ . '/../public/index.php';
