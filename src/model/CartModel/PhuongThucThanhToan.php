<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";


class PhuongThucThanhToan
{
  private $db;

  public function __construct()
  {
    $this->db = MysqlConfig::getConnection();
  }

  public function createPhuongThucThanhToan($tenPhuongThuc)
  {
    if (!isset($tenPhuongThuc)) {
      return (object)[
        "status" => 400,
        "message" => "error value"
      ];
    }
    $query = "INSERT INTO `PhuongThucThanhToan`(`TenPhuongThuc`) VALUES ('$tenPhuongThuc')";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object)[
        "status" => 200,
        "message" => "PhuongThucThanhToan created successfully"
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    }
  }

  public function getPhuongThucThanhToan($MaPhuongThuc)
  {
    $query = "SELECT * FROM `PhuongThucThanhToan` WHERE `MaPhuongThuc` = $MaPhuongThuc";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute([$MaPhuongThuc]);
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return (object)[
          "status" => 200,
          "data" => $result
        ];
      } else {
        return (object)[
          "status" => 404,
          "message" => "PhuongThucThanhToan not found"
        ];
      }
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    }
  }

  public function deletePhuongThucThanhToan($MaPhuongThuc)
  {
    $query = "DELETE FROM `PhuongThucThanhToan` WHERE `MaPhuongThuc` = $MaPhuongThuc";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute([$MaPhuongThuc]);
      return (object)[
        "status" => 200,
        "message" => "PhuongThucThanhToan deleted successfully"
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    }
  }

  public function updatePhuongThucThanhToan($MaPhuongThuc, $tenPhuongThuc)
  {
    $query = "UPDATE `PhuongThucThanhToan` SET `TenPhuongThuc` = $tenPhuongThuc WHERE `MaPhuongThuc` = $MaPhuongThuc";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute([$tenPhuongThuc, $MaPhuongThuc]);
      return (object)[
        "status" => 200,
        "message" => "PhuongThucThanhToan updated successfully"
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    }
  }

  public function __destruct()
  {
    if ($this->db) {
      $this->db = null;
    }
  }
}
