<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";

class Cart {
  private $db;

  public function createCart($MaTK, $MaSP, $DonGia, $SoLuong, $ThanhTien) {
    if (!isset($MaTK) || !isset($MaSP) || !isset($DonGia) || !isset($SoLuong) || !isset($ThanhTien)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "INSERT INTO `GioHang`(`DonGia`, `SoLuong`, `ThanhTien`, `MaTaiKhoan`, `MaSanPham`) 
              VALUES ('$DonGia', '$SoLuong', '$ThanhTien', '$MaTK', '$MaSP')";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Thêm vào giỏ hàng thành công"
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



  public function deleteCart($MaTK, $MaSanPham) {
    if (!isset($MaSanPham) || !isset($MaTK)) {
      return (object) [
        "status" => 400,
        "message" => "Giá trị không hợp lệ"
      ];
    }

    $query = "DELETE FROM `GioHang` WHERE `MaSanPham`='$MaSanPham' AND `MaTaiKhoan`='$MaTK'";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Xóa khỏi giỏ hàng thành công"
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



  public function getCart($MaTK) {
    if (!isset($MaTK)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    /* $query = "SELECT * FROM GioHang join sanpham on giohang.MaSanPham = sanpham.MaSanPham WHERE MaTaikhoan='$MaTK' "; */
    $query = "SELECT * FROM GioHang gh
        JOIN SanPham sp ON gh.MaSanPham = sp.MaSanPham 
        WHERE MaTaiKhoan = $MaTK";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return (object) [
        "status" => 200,
        "message" => "Lấy giỏ hàng thành công",
        "data" => $result,
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


  public function updateCart($MaTK, $MaSanPham, $DonGia, $SoLuong, $ThanhTien) {
    if (!isset($MaSanPham) || !isset($DonGia) || !isset($SoLuong) || !isset($ThanhTien) || !isset($MaTK)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "UPDATE `GioHang` SET `DonGia`='$DonGia', `SoLuong`='$SoLuong', `ThanhTien`='$ThanhTien' WHERE `MaSanPham`='$MaSanPham'";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Cập nhật giỏ hàng thành công"
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
