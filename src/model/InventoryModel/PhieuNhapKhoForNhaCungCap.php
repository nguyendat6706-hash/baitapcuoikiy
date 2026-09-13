<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";

class PhieuNhapKhoForNCC
{
  private $db;

  public function updatePhieuNhapKhoForNhaCungCap($maPhieu)
  {
    try {
      $this->db = MysqlConfig::getConnection();
      $sql = "UPDATE `PhieuNhapKho` SET `MaNCC` = 1 WHERE `MaPhieu` = :maPhieu;";
      $stmt = $this->db->prepare($sql);

      // Bind parameters
      $stmt->bindParam(':maPhieu', $maPhieu, PDO::PARAM_INT);

      // Execute the statement
      $stmt->execute();

      return (object) [
        "status" => 200,
        "message" => "Cập nhật phiếu nhập kho thành công."
      ];
    } catch (PDOException $error) {
      return (object) [
        "status" => 500,
        "message" => "Internal Server Error: " . $error->getMessage()
      ];
    }
  }

  public function getPhieuNhapKhoByMaNCC($MaNCC)
  {
    try {
      $this->db = MysqlConfig::getConnection();
      $sql = "SELECT * FROM `PhieuNhapKho` WHERE `MaNCC` = :MaNCC";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':MaNCC', $MaNCC, PDO::PARAM_INT); // Assuming MaNCC is an integer
      $stmt->execute();

      return (object) [
        "status" => 200,
        "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
      ];
    } catch (PDOException $error) {
      return (object) [
        "status" => 500,
        "message" => "Internal Server Error: " . $error->getMessage()
      ];
    }
  }
}
