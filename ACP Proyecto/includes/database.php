<?php
require_once __DIR__ . '/bootstrap.php';
function acp_db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    $host=acp_env('DB_HOST','127.0.0.1');
    $port=(int)acp_env('DB_PORT','3306');
    $name=acp_env('DB_NAME','acp_proyecto');
    $dsn='mysql:host='.$host.';port='.$port.';dbname='.$name.';charset=utf8mb4';
    $pdo = new PDO($dsn, acp_env('DB_USER','root'), acp_env('DB_PASSWORD',''), [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false,
    ]);
    return $pdo;
}
