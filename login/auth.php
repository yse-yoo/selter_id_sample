<?php
// auth.php
// セッションの開始
session_start();

// データベース接続 (例)
$host = 'localhost';
$dbname = 'evacuation_system';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// POST リクエストを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTされたデータを取得
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ユーザー情報をデータベースから取得
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーが存在し、パスワードが一致するか確認
    if ($user && password_verify($password, $user['password'])) {
        // 認証成功 -> セッションにユーザー情報を保存
        $_SESSION['user_id'] = $user['id'];  // ユーザーIDをセッションに保存
        $_SESSION['user_email'] = $user['email'];  // ユーザーのメールをセッションに保存
        $_SESSION['logged_in'] = true;  // ログインフラグをセット

        header("Location: ../user/");
    } else {
        // 認証失敗
        header("Location: ../login/");
    }
}
?>