<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";
class TrangThaiDonHang
{
  private $db;

  public function createTrangThaiDonHang($TrangThai, $MaDonHang, $MaNguoiCapNhat)
  {
    if (!isset($TrangThai) || !isset($MaDonHang)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $NgayCapNhat = date("Y-m-d H:i:s");

    // If $MaNguoiCapNhat is null, set it to the string 'NULL' to insert NULL into the database
    if ($MaNguoiCapNhat === null) {
      $MaNguoiCapNhatValue = 'NULL';
    } else {
      $MaNguoiCapNhatValue = $MaNguoiCapNhat;
    }

    $query = "INSERT INTO `TrangThaiDonHang`(`TrangThai`, `NgayCapNhat`, `MaDonHang`, `MaNguoiCapNhat`)
              VALUES ('$TrangThai', '$NgayCapNhat', $MaDonHang, $MaNguoiCapNhatValue)";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Thêm phương thức vận chuyển thành công",
        "sql" => $query
      ];
    } catch (\Throwable $th) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage(),
        "sql" => $query
      ];
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }


  public function updateTrangThaiDonHang($TrangThai, $MaDonHang, $MaNguoiCapNhat)
  {
    if (!isset($TrangThai) || !isset($MaDonHang) || !isset($MaNguoiCapNhat)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $NgayCapNhat = date("Y-m-d H:i:s");

    $query = "INSERT INTO TrangThaiDonHang (MaDonHang, TrangThai, NgayCapNhat, MaNguoiCapNhat)
VALUES ('$MaDonHang', '$TrangThai', '$NgayCapNhat', '$MaNguoiCapNhat')
";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Cập nhật trạng thái đơn hàng thành công"
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
