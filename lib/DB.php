<?php
// Database connection
$db_connection = DB_CONNECTION;
$db_name = DB_NAME;
$db_host = DB_HOST;
$db_port = DB_PORT;

$dsn = "{$db_connection}:dbname={$db_name};host={$db_host};port={$db_port};charset=utf8;";
$db_user = DB_USER;
$db_password = DB_PASS;

try {
    $pdo = new PDO($dsn, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage();
    exit;
}
