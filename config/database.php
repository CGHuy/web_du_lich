<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_web_du_lich";

// Tạo kết nối
$connect = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($connect->connect_error) {
    // In lỗi ra trang để bạn kiểm tra nhanh (KHÔNG nên in chi tiết lỗi trên production)
    echo "Kết nối thất bại: " . htmlspecialchars($conn->connect_error);
}

// Sau nay có thể xóa dòng này đi
echo "Kết nối DB thành công!";


// Thiết lập bộ ký tự cho kết nối
$conn->set_charset("utf8mb4");
?>