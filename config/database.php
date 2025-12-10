<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_web_du_lich";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập bộ ký tự cho kết nối
$conn->set_charset("utf8mb4");
?>