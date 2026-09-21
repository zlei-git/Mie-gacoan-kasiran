<?php

// Vercel Serverless Entrypoint for Laravel
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
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
    putenv("SESSION_DRIVER=cookie");
    putenv("CACHE_STORE=array");
    
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $targetDb;
    $_SERVER['DB_CONNECTION'] = 'sqlite';
    $_SERVER['DB_DATABASE'] = $targetDb;
}

require __DIR__ . '/../public/index.php';
