document.addEventListener("DOMContentLoaded", function () {
    // 各フィールドにテストデータを入力
    document.getElementById("name").value = "John Doe";
    document.getElementById("email").value = "john.doe@example.com";
    document.getElementById("password").value = "TestPassword123!";
    document.getElementById("confirmPassword").value = "TestPassword123!";
    document.getElementById("birthday").value = "1990-01-01";
    document.getElementById("gender").value = "male";
    document.getElementById("address").value = "1234 Main St, City, Country";
    document.getElementById("phone").value = "123-456-7890";
    document.getElementById("terms").checked = true;

    // ファイルの選択 (自動的には難しいので、UI操作が必要)
    // Photo のファイル選択は JSから直接ファイルを設定できないため、手動で行う必要があります
});