<?php
require_once '../env.php';
require_once '../lib/DB.php';

function uploadImages($userId)
{
    // ユーザー専用のフォルダを作成 (例: uploads/[userId]/)
    $userFolder = UPLOAD_DIR . $userId . '/';
    if (!file_exists($userFolder)) {
        mkdir($userFolder, 0777, true);
    }

    // ファイルがアップロードされた場合
    if (!empty($_FILES['photo']['name']) && is_array($_FILES['photo']['name'])) {
        $allowedTypes = ['jpg', 'jpeg'];

        foreach ($_FILES['photo']['name'] as $index => $name) {
            // ユニークなファイル名を生成 (例: timestamp_インデックス.jpg)
            $photoName = time() . "_{$index}.jpg";
            $targetFilePath = $userFolder . $photoName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // ファイルタイプのチェック
            if (in_array($fileType, $allowedTypes)) {
                // ファイルをアップロード
                if (move_uploaded_file($_FILES['photo']['tmp_name'][$index], $targetFilePath)) {
                    // 成功した場合、必要に応じてデータベースに記録するなどの処理を行います
                } else {
                    // 失敗した場合のエラーハンドリング
                    throw new Exception("Failed to upload file: " . $name);
                }
            } else {
                throw new Exception("Invalid file type: " . $name);
            }
        }
        return true; // 成功した場合
    } else {
        throw new Exception("No files uploaded");
    }
}

// TODO: column setting
$posts['name'] = $_POST['name'];
$posts['email'] = $_POST['email'];
$posts['password'] = $_POST['password'];
$posts['phone'] = $_POST['phone'];

// TODO: validate
// パスワードのハッシュ化 (セキュリティ上必要)
$posts['password'] = password_hash($posts['password'], PASSWORD_BCRYPT);

$sql = "INSERT INTO users (name, email, password, phone) 
               VALUES (:name, :email, :password, :phone)";

try {
    // ユーザーの挿入
    // $pdo->beginTransaction();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($posts);
    $userId = $pdo->lastInsertId();
    // $pdo->commit();

    // Upload Multiple Images
    uploadImages($userId);

    // Responce
    header('Content-Type: application/json');
    $response = ['message' => 'Registration successful!', 'userId' => $userId];
    echo json_encode($response);
} catch (Exception $e) {
    // エラーが発生した場合、ロールバック
    $pdo->rollBack();
    $response = ['error' => $e->getMessage()];
    header('Content-Type: application/json');
    echo json_encode($response);
}
