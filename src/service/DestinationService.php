<?php
require_once __DIR__ . '/../../config/database.php';

class DestinationService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Lấy danh sách địa điểm kèm thông tin người tạo
    public function getAllWithUser()
    {
        $sql = "SELECT d.id, d.name AS destination_name, d.description, u.name AS user_name, u.email FROM destinations d JOIN users u ON d.user_id = u.id";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>