<?php
require_once '../env.php';
require_once '../lib/DB.php';

$posts['id'] = $_POST['user_id'];
$sql = "SELECT * FROM users WHERE id = :id";

try {
    // ユーザーの挿入
    $stmt = $pdo->prepare($sql);
    $stmt->execute($posts);
    $user = $smtm->fetch();
} catch (Exception $e) {
    $response = ['error' => $e->getMessage()];
    header('Content-Type: application/json');
    echo json_encode($response);
}
