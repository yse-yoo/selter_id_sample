<?php
require_once "../../env.php";
require_once "../../lib/DB.php";

session_start();

// ユーザーIDをGETパラメータから取得
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

// ユーザー情報を取得
if ($user_id) {
    try {
        // ユーザーの詳細と受付状態を取得
        $stmt = $pdo->prepare("SELECT users.id AS user_id, users.name, users.email, users.gender, 
                                      users.birthday_at, users.address, users.emergency_contact,
                                      receptions.recepted_at
                               FROM users 
                               LEFT JOIN receptions ON users.id = receptions.user_id 
                               WHERE users.id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("User not found.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("User ID not specified.");
}

// 受付状態の判定
$reception_status = $user['recepted_at'] ? "受付済" : "未受付";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reception Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="p-4 shadow-md fixed w-full top-0 z-10 bg-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php">
                <h1 class="text-xl font-bold text-purple-600">SHELTER ID</h1>
            </a>
            <ul class="flex space-x-4">
                <li><a href="reception.php" class="text-purple-500 hover:text-purple-700">Reception</a></li>
                <li><a href="register.php" class="text-purple-500 hover:text-purple-700">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto p-8 mt-24 bg-white shadow-lg rounded-lg">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-700">Reception Details for <?= htmlspecialchars($user['name']) ?></h1>

        <div class="flex flex-col items-center space-y-6">
            <!-- User Photo -->
            <img src="../../images/no_avator.png" alt="<?= htmlspecialchars($user['name']) ?>'s Profile Image" class="h-32 w-32 object-cover rounded-full border border-gray-300 shadow-md">

            <!-- User Info (as a table) -->
            <div class="w-full max-w-md bg-gray-50 p-6 rounded-lg shadow-md">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="font-bold">User ID:</div>
                    <div><?= htmlspecialchars($user['user_id']) ?></div>

                    <div class="font-bold">Name:</div>
                    <div><?= htmlspecialchars($user['name']) ?></div>

                    <div class="font-bold">Reception Status:</div>
                    <div><?= htmlspecialchars($reception_status) ?></div>

                    <div class="font-bold">Email:</div>
                    <div><?= htmlspecialchars($user['email']) ?></div>

                    <div class="font-bold">Gender:</div>
                    <div><?= htmlspecialchars($user['gender']) ?></div>

                    <div class="font-bold">Date of Birth:</div>
                    <div><?= htmlspecialchars($user['birthday_at']) ?></div>

                    <div class="font-bold">Address:</div>
                    <div><?= htmlspecialchars($user['address']) ?></div>

                    <div class="font-bold">Emergency Contact:</div>
                    <div><?= htmlspecialchars($user['emergency_contact']) ?></div>

                    <div class="font-bold">Reception Date & Time:</div>
                    <div><?= htmlspecialchars($user['recepted_at'] ?? 'N/A') ?></div>
                </div>
            </div>

            <!-- Back to List Button -->
            <div class="mt-6">
                <a href="./" class="py-2 px-4 rounded-md">Back</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Yokohama System Engineering College. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>