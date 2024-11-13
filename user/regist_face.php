<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: ../login/");
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顔認証登録</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 fixed w-full top-0 z-10">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold text-purple-600">SHELTER ID</a>
            <ul class="flex space-x-4">
                <li><a href="./" class="text-gray-500 hover:text-gray-700">Home</a></li>
                <li><a href="regist_face.php" class="text-gray-500 hover:text-gray-700">Regist Face</a></li>
                <li><a href="logout.php" class="text-gray-500 hover:text-gray-700">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- main -->
    <main class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-center mb-6">顔認証登録</h1>

        <div id="message" class="mt-4 text-green-500"></div>

        <div id="video-area" class="flex flex-col items-center"> <!-- flex-colで縦並び、items-centerで中央寄せ -->
            <input type="file" id="photo" class="hidden">
            <video id="video" width="320" height="240" autoplay style="display:none;" class="mt-4"></video>

            <!-- ボタンを縦並びに配置 -->
            <div class="mt-4">
                <button onclick="onCapture()" type="button" id="captureBtn" class="bg-purple-500 text-white px-3 py-2 rounded-md">Capture Image</button>
            </div>
        </div>

        <div id="canvas-area" class="flex my-4">

        </div>

        <input type="hidden" name="user_id" id="user-id" value="<?= $user_id ?>">

        <div id="regist-area" class="flex flex-col items-center hidden">
            <button onclick="regist()" type="button" id="captureBtn" class="bg-purple-500 text-white px-3 py-2 rounded-md mt-4">Regist Images</button>
        </div>
    </main>

    <script src="../js/env.js" defer></script>
    <script src="../js/regist_face.js" defer></script>
</body>

</html>