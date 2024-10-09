const openCameraBtn = document.getElementById('openCameraBtn');
const video = document.getElementById('video');
const captureBtn = document.getElementById('captureBtn');
const canvas = document.getElementById('canvas');
const photoInput = document.getElementById('photo');

// キャプチャされた画像を保持するための DataTransfer オブジェクト
const dataTransfer = new DataTransfer();

const regist = async (e) => {
    e.preventDefault();
    alert('ok');

    const formData = new FormData(e.target); // 修正：e.target でフォーム全体を取得

    // フォームデータにキャプチャされた画像ファイルを追加
    for (let i = 0; i < dataTransfer.files.length; i++) {
        formData.append('photo[]', dataTransfer.files[i]);
    }

    const responseMessage = document.getElementById('responseMessage');

    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            body: formData,
        });

        const contentType = response.headers.get('Content-Type');

        if (response.ok && contentType && contentType.includes('application/json')) {
            const result = await response.json();
            responseMessage.textContent = result.message || 'Registration Successful!';
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

const onCamera = async (e) => {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    video.srcObject = stream;
    video.style.display = 'block';
    captureBtn.style.display = 'block';
}

const onCapture = (e) => {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    canvas.toBlob((blob) => {
        const file = new File([blob], `captured-image-${Date.now()}.jpg`, { type: 'image/jpeg' });

        // DataTransfer にキャプチャした画像を追加
        dataTransfer.items.add(file);

        // 更新したファイルリストを <input> 要素に反映
        photoInput.files = dataTransfer.files;

        // 表示を隠す
        video.style.display = 'none';
        captureBtn.style.display = 'none';

        // デバッグ用：追加されたファイルのリストを確認
        console.log(dataTransfer.files);
    });
}