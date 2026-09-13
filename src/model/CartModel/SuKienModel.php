<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";

class SuKien
{
  private $db;

  public function createSuKien($TenSuKien, $NgayBatDau, $NgayKetThuc)
  {
    if (!isset($TenSuKien) || !isset($NgayBatDau) || !isset($NgayKetThuc)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "INSERT INTO `SuKien`(`TenSuKien`, `NgayBatDau`, `NgayKetThuc`) VALUES ('$TenSuKien', '$NgayBatDau', '$NgayKetThuc')";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Tạo sự kiện thành công"
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }

  public function getSuKien($MaSuKien)
  {
    if (!isset($MaSuKien)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "SELECT * FROM `SuKien` WHERE `MaSuKien`='$MaSuKien'";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }

  public function updateSuKien($MaSuKien, $TenSuKien, $NgayBatDau, $NgayKetThuc)
  {
    if (!isset($MaSuKien) || !isset($TenSuKien) || !isset($NgayBatDau) || !isset($NgayKetThuc)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "UPDATE `SuKien` SET `TenSuKien`='$TenSuKien', `NgayBatDau`='$NgayBatDau', `NgayKetThuc`='$NgayKetThuc' WHERE `MaSuKien`='$MaSuKien'";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Cập nhật sự kiện thành công"
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }

  public function deleteSuKien($MaSuKien)
  {
    if (!isset($MaSuKien)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "DELETE FROM `SuKien` WHERE `MaSuKien`='$MaSuKien'";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Xóa sự kiện thành công"
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }
}
