<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";

class ChiTietPhieuNhapKhoModel
{
    private $db;

    public function __construct()
    {
        $this->db = MysqlConfig::getConnection();
    }

    public function createChiTietPhieuNhapKho($maPhieu, $maSanPham, $donGiaNhap, $soLuong, $thanhTien)
    {
        try {
            $query = "INSERT INTO CTPNK (DonGiaNhap, SoLuong, ThanhTien, MaPhieu, MaSanPham) 
                    VALUES (:DonGiaNhap, :SoLuong, :ThanhTien, :MaPhieu, :MaSanPham)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':DonGiaNhap' => $donGiaNhap,
                ':SoLuong' => $soLuong,
                ':ThanhTien' => $thanhTien,
                ':MaPhieu' => $maPhieu,
                ':MaSanPham' => $maSanPham
            ]);
            $newID = $this->db->lastInsertId();
            return (object) [
                "status" => 200,
                "message" => "Thêm chi tiết phiếu nhập kho thành công.",
                "id" => $newID
            ];
        } catch (PDOException $error) {
            return (object) [
                "status" => 400,
                "message" => "Error: " . $error->getMessage()
            ];
        }
    }

    public function getChiTietPhieuNhapKho($maPhieu)
    {
        try {
            $query = "SELECT * FROM CTPNK JOIN `SanPham` ON `CTPNK`.`MaSanPham` = `SanPham`.`MaSanPham` WHERE `CTPNK`.`MaPhieu` = :MaPhieu;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':MaPhieu' => $maPhieu
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return (object) [
                "status" => 200,
                "data" => $result
            ];
        } catch (PDOException $error) {
            return (object) [
                "status" => 400,
                "message" => "Error: " . $error->getMessage()
            ];
        }
    }

}

?>
