<?php
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "123";
    private $dbname = "db_web_du_lich";
    private $debug = false;
    public $connect;

    public function __construct()
    {
        try {
            $this->connect = new mysqli(
                $this->servername,
                $this->username,
                $this->password,
                $this->dbname
            );
            $this->connect->set_charset("utf8mb4");

            if ($this->debug) {
                error_log("Kết nối DB thành công!");
            }
        } catch (mysqli_sql_exception $e) {
            if ($this->debug) {
                error_log("Kết nối thất bại: " . $e->getMessage());
            } else {
                error_log("DB connection failed: " . $e->getMessage());
            }
            http_response_code(500);
            echo "Đã xảy ra lỗi kết nối. Vui lòng thử lại sau.";
            exit;
        }
    }

    public function getConnection()
    {
        return $this->connect;
    }

    public function close()
    {
        if ($this->connect) {
            $this->connect->close();
        }
    }
}
?>