const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const responseMessage = document.getElementById('responseMessage');

// キャプチャされた画像を保持するための DataTransfer オブジェクト
var dataTransfer = new DataTransfer();

// 受付処理
const recept = async (file) => {
    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await fetch(API_RECEPT_FACE_URL, {
            method: 'POST',
            body: formData,
        });

        const contentType = response.headers.get('Content-Type');
        if (response.ok && contentType && contentType.includes('application/json')) {
            const result = await response.json();
            console.log(result)
            if (result.user_id > 0) {
                responseMessage.textContent = "Recept Success!!";
                addRecept(result.user_id)
            } else {
                responseMessage.textContent = "Recept Error!";
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
        const file = new File([blob], `captured-image.jpg`, { type: 'image/jpeg' });
        // dataTransfer = new DataTransfer();
        // dataTransfer.items.add(file);
        callback(file);
    });
};

// ページロード時にカメラを起動
window.onload = () => {
    onCamera();
};

const addRecept = (userId) => {
    document.getElementById('user-id').value = userId;
    document.getElementById('receipt-form').submit();
}

onCamera();