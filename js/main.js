const registrationForm = document.getElementById('registrationForm');
const openCameraBtn = document.getElementById('openCameraBtn');
const video = document.getElementById('video');
const captureBtn = document.getElementById('captureBtn');
const canvas = document.getElementById('canvas');
const photoInput = document.getElementById('photo');

// キャプチャされた画像を保持するための DataTransfer オブジェクト
const dataTransfer = new DataTransfer();

// 登録処理
const regist = async (e) => {
    e.preventDefault(); // フォームのデフォルト送信を防ぐ

    const formData = new FormData(e.target);
    const responseMessage = document.getElementById('responseMessage');

    // Test
    // registFaces(1);
    // return;

    try {
        const response = await fetch(API_REGIST_URL, {
            method: 'POST',
            body: formData,
        });

        const contentType = response.headers.get('Content-Type');

        if (response.ok && contentType && contentType.includes('application/json')) {
            const result = await response.json();
            responseMessage.textContent = result.message || 'Registration Successful!';
            console.log(result)
            if (result.userId) {
                registFaces(result.userId);
            }
        } else if (contentType && contentType.includes('text/html')) {
            const html = await response.text();
            responseMessage.textContent = `Error: Server returned HTML: ${html}`;
        } else {
            throw new Error('Unexpected response format');
        }
    } catch (error) {
        responseMessage.textContent = `Error: ${error.message}`;
        responseMessage.style.color = 'red';
    }
}

const registFaces = async (userId) => {
    const formData = new FormData();
    formData.append('user_id', userId);
    // フォームデータにキャプチャされた画像ファイルを追加
    // 複数のファイルをFormDataに追加
    for (let i = 0; i < dataTransfer.files.length; i++) {
        formData.append('images', dataTransfer.files[i]);
    }
    console.log(userId, dataTransfer.files)

    try {
        const response = await fetch(API_REGIST_FACE_URL, {
            method: 'POST',
            body: formData,
        });

        const contentType = response.headers.get('Content-Type');
        if (response.ok && contentType && contentType.includes('application/json')) {
            const result = await response.json();
            console.log(result)
        } else if (contentType && contentType.includes('text/html')) {
            const html = await response.text();
            responseMessage.textContent = `Error: Server returned HTML: ${html}`;
        } else {
            throw new Error('Unexpected response format');
        }
    } catch (error) {
        responseMessage.textContent = `Error: ${error.message}`;
        responseMessage.style.color = 'red';
    }
}


// カメラ起動処理
const onCamera = async (e) => {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    video.srcObject = stream;
    video.style.display = 'block';
    captureBtn.style.display = 'block';
}

// 画像キャプチャ処理 (0.5秒間隔で10枚の画像を追加)
const onCapture = (e) => {
    const context = canvas.getContext('2d');
    let count = 0;

    const captureImage = () => {
        if (count < 10) {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            canvas.toBlob((blob) => {
                const file = new File([blob], `captured-image-${Date.now()}-${count}.jpg`, { type: 'image/jpeg' });

                // DataTransfer にキャプチャした画像を追加
                dataTransfer.items.add(file);

                // 更新したファイルリストを <input> 要素に反映
                photoInput.files = dataTransfer.files;

                // デバッグ用：追加されたファイルのリストを確認
                // console.log(`Captured image ${count + 1}:`, dataTransfer.files);
            });

            count++;
            setTimeout(captureImage, 500); // 0.5秒間隔で次のキャプチャを実行
        } else {
            // 全てのキャプチャが完了した後に表示を隠す
            video.style.display = 'none';
            captureBtn.style.display = 'none';
        }
    };

    captureImage(); // 最初のキャプチャを開始
};

// フォーム送信イベントリスナー
registrationForm.addEventListener('submit', regist);
