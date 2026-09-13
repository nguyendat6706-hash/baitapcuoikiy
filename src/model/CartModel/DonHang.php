<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";

class DonHang
{
  private $db;
  public function createDonHang($TongGiaTri, $MaKH, $DiaChi, $PhuongThucThanhToan, $PhuongThucVanChuyen)
  {
    if (!isset($TongGiaTri) || !isset($MaKH) || !isset($DiaChi) || !isset($PhuongThucThanhToan) || !isset($PhuongThucVanChuyen)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $NgayDat = date("Y-m-d H:i:s");

    $query = "INSERT INTO `DonHang`(`NgayDat`, `TongGiaTri`, `MaKH`,`DiaChiGiaoHang` ,`MaPhuongThuc`, `MaDichVu`)
              VALUES ( '$NgayDat', '$TongGiaTri', '$MaKH','$DiaChi', '$PhuongThucThanhToan', '$PhuongThucVanChuyen')";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
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

  public function getDonHang($MaKhachHang)
  {
    if (!isset($MaKhachHang)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "
        SELECT DonHang.*, TrangThaiDonHang.TrangThai AS TenTrangThai, TrangThaiDonHang.NgayCapNhat, TrangThaiDonHang.MaNguoiCapNhat, CTDH.*, SanPham.*
FROM DonHang
JOIN (
    SELECT MaDonHang, TrangThai, NgayCapNhat, MaNguoiCapNhat
    FROM TrangThaiDonHang
    WHERE (MaDonHang, NgayCapNhat) IN (
        SELECT MaDonHang, MAX(NgayCapNhat)
        FROM TrangThaiDonHang
        GROUP BY MaDonHang
    )
) AS TrangThaiDonHang ON DonHang.MaDonHang = TrangThaiDonHang.MaDonHang
JOIN CTDH ON CTDH.MaDonHang = DonHang.MaDonHang
JOIN SanPham ON SanPham.MaSanPham = CTDH.MaSanPham
JOIN PhuongThucThanhToan ON DonHang.MaPhuongThuc = PhuongThucThanhToan.MaPhuongThuc
WHERE DonHang.MaKH = $MaKhachHang;


      ";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
        "sql" => $query
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

  public function getAllDonHang()
  {
    $query = "SELECT DonHang.*, TrangThaiDonHang.TrangThai AS TenTrangThai, CTDH.*, SanPham.*, PhuongThucThanhToan.*, TrangThaiDonHang.NgayCapNhat, TrangThaiDonHang.MaNguoiCapNhat
          FROM DonHang
          JOIN TrangThaiDonHang ON DonHang.MaDonHang = TrangThaiDonHang.MaDonHang
          JOIN CTDH ON CTDH.MaDonHang = DonHang.MaDonHang
          JOIN SanPham ON SanPham.MaSanPham = CTDH.MaSanPham
          JOIN PhuongThucThanhToan ON DonHang.MaPhuongThuc = PhuongThucThanhToan.MaPhuongThuc;
";


    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
        "sql" => $query
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

  public function getDonHangByIdDonhang($MaDonHang)
  {
    if (!isset($MaDonHang)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "
       SELECT *
            , TrangThaiDonHang.TrangThai AS TenTrangThai
        FROM DonHang 
       JOIN (
    SELECT MaDonHang, TrangThai, NgayCapNhat, MaNguoiCapNhat
    FROM TrangThaiDonHang
    WHERE MaDonHang =$MaDonHang  
    ORDER BY NgayCapNhat DESC 
    LIMIT 1 
) AS TrangThaiDonHang ON DonHang.MaDonHang = TrangThaiDonHang.MaDonHang
        JOIN CTDH ON CTDH.MaDonHang = DonHang.MaDonHang 
        JOIN SanPham ON SanPham.MaSanPham = CTDH.MaSanPham
        JOIN NguoiDung ON NguoiDung.MaTaiKhoan = DonHang.MaKH
        JOIN PhuongThucThanhToan ON DonHang.MaPhuongThuc = PhuongThucThanhToan.MaPhuongThuc
        JOIN DichVuVanChuyen ON DonHang.MaDichVu = DichVuVanChuyen.MaDichVu
        WHERE DonHang.MaDonHang = $MaDonHang";


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

  public function updateDonHang($MaDonHang, $TongGiaTri, $MaKH, $PhuongThucThanhToan, $PhuongThucVanChuyen)
  {
    if (!isset($MaDonHang) || !isset($TongGiaTri) || !isset($MaKH) || !isset($PhuongThucThanhToan) || !isset($PhuongThucVanChuyen)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "UPDATE `DonHang` SET `TongGiaTri`='$TongGiaTri', `MaKH`='$MaKH', `MaPhuongThuc`='$PhuongThucThanhToan', `MaDichVu`='$PhuongThucVanChuyen' WHERE `MaDonHang`='$MaDonHang'";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Cập nhật đơn hàng thành công"
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

  public function deleteDonHang($MaDonHang)
  {
    if (!isset($MaDonHang)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "UPDATE `TrangThaiDonHang` SET `TrangThai`=`Huy`";


    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Xóa đơn hàng thành công"
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

  public function create_Ct_DonHang($MaDonHang, $MaSP, $DonGia, $SoLuong, $ThanhTien)
  {
    if (!isset($MaDonHang) || !isset($MaSP) || !isset($DonGia) || !isset($SoLuong) || !isset($ThanhTien)) {
      return (object) [
        "status" => 400,
        "message" => "error value"
      ];
    }

    $query = "INSERT INTO `CTDH`(`SoLuong`, `ThanhTien`,`DonGia`,  `MaDonHang`, `MaSanPham`) 
              VALUES ( '$SoLuong', '$ThanhTien','$DonGia', '$MaDonHang', '$MaSP')";

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Thêm đơn hàng thành công"
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

  public function getIDDonHangMoiChen()
  {
    $this->db = MysqlConfig::getConnection();

    try {
      $query = "SELECT MAX(MaDonHang) AS LastInsertedID FROM DonHang";
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      return $result['LastInsertedID'];
    } catch (\Throwable $th) {
      return null;
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }
  public function filterDonHang($maDonHang, $tuNgay, $denNgay, $trangThai)
  {
    $conditions = [];

    // Xây dựng điều kiện WHERE dựa trên các tham số được truyền vào
    if ($maDonHang != "") {
      $conditions[] = "DonHang.MaDonHang = $maDonHang";
    }
    if ($tuNgay !== "") {
      $conditions[] = "TrangThaiDonHang.NgayCapNhat > DATE('$tuNgay')";
    }
    if ($denNgay !== "") {
      $conditions[] = "TrangThaiDonHang.NgayCapNhat < DATE('$denNgay')";
    }
    if ($trangThai !== "") {
      $subquery = "TrangThaiDonHang.trangthai";
      $conditions[] = "($subquery) = '$trangThai'";
    }

    // Gộp các điều kiện thành một chuỗi
    $whereClause = '';
    if (!empty($conditions)) {
      $whereClause = 'WHERE ' . implode(' AND ', $conditions);
    }

    // Tạo truy vấn SQL
    $query = "
    SELECT `DonHang`.*, `TrangThaiDonHang`.`TrangThai` as `TenTrangThai`, `PhuongThucThanhToan`.`TenPhuongThuc`, `DichVuVanChuyen`.`TenDichVu`
    FROM DonHang
    JOIN CTDH ON CTDH.MaDonHang = DonHang.MaDonHang
    JOIN SanPham ON SanPham.MaSanPham = CTDH.MaSanPham
    JOIN PhuongThucThanhToan ON DonHang.MaPhuongThuc = PhuongThucThanhToan.MaPhuongThuc
    JOIN DichVuVanChuyen ON DichVuVanChuyen.MaDichVu = DonHang.MaDichVu


    LEFT JOIN TrangThaiDonHang ON DonHang.MaDonHang = TrangThaiDonHang.MaDonHang
    $whereClause AND
    TrangThaiDonHang.NgayCapNhat=(
    SELECT MAX(`NgayCapNhat`) FROM `TrangThaiDonHang` subtt 
          WHERE DonHang.`MaDonHang` = subtt.`MaDonHang`)
          GROUP BY `DonHang`.`MaDonHang`, `TrangThaiDonHang`.`TrangThai`
    ";
    // echo $query;

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
        "sql" => $query
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
