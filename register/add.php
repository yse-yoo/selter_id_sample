<?php
session_start();

require_once '../env.php';
require_once '../lib/DB.php';

$posts['name'] = $_POST['name'];
$posts['email'] = $_POST['email'];
$posts['password'] = $_POST['password'];
$posts['phone'] = $_POST['phone'];
$posts['password'] = password_hash($posts['password'], PASSWORD_BCRYPT);

try {
    // Emailの重複チェック
    $checkEmailSql = "SELECT COUNT(*) FROM users WHERE email = :email";
    $checkStmt = $pdo->prepare($checkEmailSql);
    $checkStmt->execute(['email' => $posts['email']]);
    $emailCount = $checkStmt->fetchColumn();

    if ($emailCount > 0) {
        // Emailが既に存在する場合はエラーを返す
        $_SESSION['error'] = 'Email is already registered.';
        header("Location: ./");
        exit;
    }

    // ユーザーの挿入
    $sql = "INSERT INTO users (name, email, password, phone) 
                   VALUES (:name, :email, :password, :phone)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($posts);

    $user_id = $pdo->lastInsertId();
    if ($user_id > 0) {
        // user_id をセッションに登録
        $_SESSION['user_id'];
        header("Location: ../user/regist_face.php");
        exit;
    } else {
        header("Location: ./");
        exit;
    }
} catch (Exception $e) {
    // エラーが発生した場合の処理
    header("Location: ./");
}
