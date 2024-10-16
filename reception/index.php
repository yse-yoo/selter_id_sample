<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evacuation Face Recognition</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="container max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg bg-opacity-90">
        <h1 class="text-2xl font-bold text-center mb-6">Evacuation Registration</h1>

        <!-- カメラ映像を表示するビデオタグ -->
        <video id="video" width="320" height="240" autoplay class="mt-4"></video>
        
        <!-- キャプチャした画像を保持するキャンバス -->
        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
        
        <button type="button" class="w-full bg-purple-500 text-white py-2 rounded-md" onclick="onDetect()">Detect</button>
        <!-- 受付ボタン -->
        <button type="button" class="w-full bg-purple-500 text-white py-2 rounded-md" onclick="onRecept()">Reception</button>

        <!-- レスポンスメッセージを表示 -->
        <div id="responseMessage" class="mt-4"></div>
    </div>

    <script src="../js/env.js"></script>
    <script src="../js/recept.js"></script>
</body>

</html>
