<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_web_du_lich";

$debug = true; // sau này có thể chuyển sang false để tắt debug

try {
    $connect = new mysqli($servername, $username, $password, $dbname);
    if ($debug) {
        echo "Kết nối DB thành công!";
    }
} catch (mysqli_sql_exception $e) {
    if ($debug) {
        echo "Kết nối thất bại: " . htmlspecialchars($e->getMessage());
    } else {
        error_log("DB connection failed: " . $e->getMessage());
        http_response_code(500);
        echo "Đã xảy ra lỗi kết nối. Vui lòng thử lại sau.";
    }
    exit;
}

// Thiết lập bộ ký tự cho kết nối
$connect->set_charset("utf8mb4");
?>