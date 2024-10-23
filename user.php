<?php
include 'config.php';
class User {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function login($nik, $password) {
        $stmt = $this->db->koneksi->prepare("SELECT * FROM guru WHERE nik = ? AND password_guru = ?");
        $stmt->bind_param("ss", $nik, $password); // Menggunakan parameter bind untuk keamanan
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
}
?>