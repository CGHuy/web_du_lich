<?php
require_once __DIR__ . '/../../config/database.php';
class Tour {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM tours";
        $result = $this->conn->query($sql);
        $tours = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $tours[] = $row;
        return $tours;
    }
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $slug, $description, $location, $region, $duration, $price_default, $cover_image) {
        $stmt = $this->conn->prepare("INSERT INTO tours (name, slug, description, location, region, duration, price_default, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssdb", $name, $slug, $description, $location, $region, $duration, $price_default, $cover_image);
        if ($cover_image !== null) {
            $stmt->send_long_data(7, $cover_image);
        }
        return $stmt->execute();
    }
    
    public function update($id, $name, $slug, $description, $location, $region, $duration, $price_default, $cover_image) {
        if ($cover_image !== null) {
            // Cập nhật tất cả bao gồm cả ảnh mới
            $stmt = $this->conn->prepare("UPDATE tours SET name = ?, slug = ?, description = ?, location = ?, region = ?, duration = ?, price_default = ?, cover_image = ? WHERE id = ?");
            $stmt->bind_param("ssssssdbi", $name, $slug, $description, $location, $region, $duration, $price_default, $cover_image, $id);
            $stmt->send_long_data(7, $cover_image);
        } else {
            // Không cập nhật cột cover_image nếu người dùng không chọn file mới
            $stmt = $this->conn->prepare("UPDATE tours SET name = ?, slug = ?, description = ?, location = ?, region = ?, duration = ?, price_default = ? WHERE id = ?");
            $stmt->bind_param("ssssssdi", $name, $slug, $description, $location, $region, $duration, $price_default, $id);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM tours WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function __destruct() {
        $this->db->close();
    }
}
