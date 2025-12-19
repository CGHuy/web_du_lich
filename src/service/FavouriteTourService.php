<?php
require_once __DIR__ . '/../models/Wishlist.php';
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../../config/database.php';

class FavouriteTourService
{
    private $db;
    private $conn;
    private $wishlistModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->wishlistModel = new Wishlist();
    }

    /**
     * Lấy danh sách tour yêu thích của user, join bảng wishlist và tours
     * @param int $user_id
     * @return array
     */
    public function getFavouriteToursByUser($user_id)
    {
        $sql = "SELECT w.id as wishlist_id, w.wish_code, t.*
                FROM wishlist w
                JOIN tours t ON w.tour_id = t.id
                WHERE w.user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $favouriteTours = [];
        while ($row = $result->fetch_assoc()) {
            $favouriteTours[] = $row;
        }
        return $favouriteTours;
    }

    /**
     * Xóa tour yêu thích theo wishlist_id
     */
    public function deleteFavourite($wishlist_id)
    {
        $sql = "DELETE FROM wishlist WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $wishlist_id);
        return $stmt->execute();
    }
}
