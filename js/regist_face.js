const registrationForm = document.getElementById('registrationForm');
const openCameraBtn = document.getElementById('openCameraBtn');
const video = document.getElementById('video');
const captureBtn = document.getElementById('captureBtn');
const photoInput = document.getElementById('photo');
const message = document.getElementById('message');
const registArea = document.getElementById('regist-area');
const canvasArea = document.getElementById('canvas-area');
const loadingModal = document.createElement('div'); // ローディングモーダルを作成
const maxImageCount = 5;

// モーダルのスタイルを設定
loadingModal.classList.add('fixed', 'inset-0', 'flex', 'items-center', 'justify-center', 'bg-black', 'bg-opacity-50', 'z-50', 'hidden');
loadingModal.innerHTML = `
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <p class="text-lg font-semibold">Processing...</p>
    </div>
`;
document.body.appendChild(loadingModal);

// キャプチャされた画像を保持するための DataTransfer オブジェクト
const dataTransfer = new DataTransfer();

// カメラ起動処理
const onCamera = async (e) => {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    video.srcObject = stream;
    video.style.display = 'block';
    captureBtn.style.display = 'block';
}

// 画像キャプチャ処理
const onCapture = async (e) => {
    let count = 0;
    const scale = 0.5; // 縮小する比率（50%）

    const captureImage = () => {
        if (count < maxImageCount) {
            // 新しい canvas 要素を作成
            const newCanvas = document.createElement('canvas');
            newCanvas.width = 320 * scale; // 縮小後の幅
            newCanvas.height = 240 * scale; // 縮小後の高さ
            canvasArea.appendChild(newCanvas);

            const context = newCanvas.getContext('2d');
            context.scale(scale, scale); // コンテキストのスケールを設定
            context.drawImage(video, 0, 0, 320, 240); // 元の画像サイズで描画

            newCanvas.toBlob((blob) => {
                const file = new File([blob], `captured-image-${Date.now()}-${count}.jpg`, { type: 'image/jpeg' });

                // DataTransfer にキャプチャした画像を追加
                dataTransfer.items.add(file);

                // 更新したファイルリストを <input> 要素に反映
                photoInput.files = dataTransfer.files;
            });

            count++;
            setTimeout(captureImage, 1000); // 次のキャプチャを一定間隔で実行
        } else {
            registArea.classList.remove('hidden');
        }
    };

    captureImage(); // 最初のキャプチャを開始
};


// 登録処理
const regist = async (e) => {
    // モーダル表示
    loadingModal.classList.remove('hidden');

    // ユーザーID取得
    const userId = document.getElementById('user-id').value;
    if (userId > 0) {
        await registFaces(userId);
    } else {
        alert('Invalid user ID');
    }

    // モーダル非表示
    loadingModal.classList.add('hidden');

    // 登録処理が終了したら canvas を非表示に
    [...canvasArea.children].forEach(canvas => canvas.style.display = 'none');
};

const registFaces = async (userId) => {
    const formData = new FormData();
    formData.append('user_id', userId);
    // フォームデータにキャプチャされた画像ファイルを追加
    for (let i = 0; i < dataTransfer.files.length; i++) {
        formData.append('images', dataTransfer.files[i]);
    }
    console.log(userId, dataTransfer.files);

    try {
        const response = await fetch(API_REGIST_FACE_URL, {
            method: 'POST',
            body: formData,
        });
        if (response.ok) {
            const result = await response.json();
            // リクエストが成功した場合、ダッシュボードにリダイレクト
            window.location.href = '../user/';
        } else {
            throw new Error('Unexpected response format');
        }
    } catch (error) {
        message.textContent = `Error: ${error.message}`;
        message.style.color = 'red';
    }
};


onCamera();