const video = document.getElementById('video');
const canvas = document.getElementById('canvas');

// キャプチャされた画像を保持するための DataTransfer オブジェクト
const dataTransfer = new DataTransfer();

// 顔認識
const detect = async () => {
    const formData = new FormData();
    // フォームデータにキャプチャされた画像ファイルを追加
    if (dataTransfer.files.length > 0) {
        formData.append('file', dataTransfer.files[0]);
        console.log(dataTransfer.files[0]);
    } else {
        console.error("No captured image to send.");
        return;
    }

    const responseMessage = document.getElementById('responseMessage');

    try {
        const response = await fetch(API_DETECT_URL, {
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
};

// 受付処理
const recept = async () => {
    const formData = new FormData();  // フォームデータを画像ファイルのみで作成

    // フォームデータにキャプチャされた画像ファイルを追加
    if (dataTransfer.files.length > 0) {
        formData.append('file', dataTransfer.files[0]);  // "file" フィールドで画像を送信
        console.log(dataTransfer.files[0]);
    } else {
        console.error("No captured image to send.");
        return;
    }

    const responseMessage = document.getElementById('responseMessage');

    try {
        const response = await fetch(API_RECEPT_URL, {
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
};

// カメラ起動処理
const onCamera = async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;

        // ビデオサイズに基づいてキャンバスサイズを設定
        video.onloadedmetadata = () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
        };
    } catch (error) {
        console.error("Error accessing the camera:", error);
        alert("Unable to access the camera. Please check your device permissions.");
    }
};

const onDetect = () => {
    captureImage(detect)
}

const onRecept = () => {
    captureImage(recept)
}

// 画像キャプチャと送信処理
const captureImage = (callback) => {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob((blob) => {
        const file = new File([blob], `captured-image-${Date.now()}.jpg`, { type: 'image/jpeg' });

        // DataTransfer にキャプチャした画像を追加
        dataTransfer.items.add(file);

        callback();
    });
};

// ページロード時にカメラを起動
window.onload = () => {
    onCamera();
};
