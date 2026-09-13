<?php


$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";

require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";


class PhanQuyenModel {
  private $totalPages = null;

  private $nguoiDungModel;

  private $db;

  // Hàm khởi tạo của lớp
  public function __construct() {
    $this->nguoiDungModel = new NguoiDungModel();
  }


  public function getPhanQuyenByMaQuyen($maQuyen) {

    $query = "SELECT * FROM `PhanQuyen` WHERE `MaQuyen` = :maQuyen";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        $statement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return (object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $result,
        ];
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy quyền",
      ];
    } finally {
      $this->db = null;
    }
  }

  public function createPhanQuyen($maQuyen, $maChucNang) {

    $query = "INSERT INTO `PhanQuyen` (`MaQuyen`, `MaChucNang`) 
                        VALUES (:maQuyen, :maChucNang)";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);


      if ($statement  !== false) {

        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':maChucNang', $maChucNang,        PDO::PARAM_INT);
        $statement->bindValue(':maQuyen', $maQuyen,            PDO::PARAM_INT);


        // Thực hiện truy vấn
        $statement = $statement->execute();


        if ($statement) {
          // Trả về ID của bản ghi vừa chèn

          return (object) [
            "status" => 200,
            "message" => "Thành công",
          ];
        } else {

          // Trả về false nếu không thành công
          throw new PDOException();
        }
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể tạo quyền",
      ];
    } finally {
      $this->db = null;
    }
  }

  public function updatePhanQuyen($maQuyen, $danhSachChucNang) {

    $deletePhanQuyenCu = $this->deletePhanQuyen($maQuyen);

    $query = "INSERT INTO `PhanQuyen` (`MaQuyen`, `MaChucNang`) 
            VALUES (:maQuyen, :maChucNang)";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);


      if ($statement  !== false) {

        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':maChucNang',  $danhSachChucNang,        PDO::PARAM_INT);
        $statement->bindValue(':maQuyen', $maQuyen,            PDO::PARAM_INT);


        // Thực hiện truy vấn
        $statement = $statement->execute();


        if ($statement) {
          // Trả về ID của bản ghi vừa chèn
          return (object) [
            "status" => 200,
            "message" => "Thành công",
          ];
        } else {

          // Trả về false nếu không thành công
          throw new PDOException();
        }
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể tạo quyền",
      ];
    } finally {
      $this->db = null;
    }
  }


  public function deletePhanQuyen($maQuyen) {
    $query = "DELETE FROM `PhanQuyen` WHERE `MaQuyen` = :maQuyen";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement  !== false) {
        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':maQuyen', $maQuyen,            PDO::PARAM_INT);

        // Thực hiện truy vấn
        $statement = $statement->execute();

        if ($statement) {
          // Trả về ID của bản ghi vừa chèn
          return (object) [
            "status" => 200,
            "message" => "Thành công",
          ];
        } else {
          // Trả về false nếu không thành công
          throw new PDOException();
        }
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể xóa quyền",
      ];
    } finally {
      $this->db = null;
    }
  }

  public function getChucNangByMaQuyen($maQuyen) {
    $query = "SELECT ChucNang.*
    FROM PhanQuyen
    JOIN ChucNang ON PhanQuyen.maChucNang = ChucNang.maChucNang
    WHERE MaQuyen = :maQuyen";

    try {
      // Khởi tạo kết nối
      $this->db = MysqlConfig::getConnection();

      $statement = $this->db->prepare($query);

      // Kiểm tra nếu prepare statement thành công
      if ($statement !== false) {
        $statement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);
        $statement->execute();

        // Lấy tất cả các dòng kết quả dưới dạng mảng kết hợp
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Trả về kết quả
        return (object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $result,
        ];
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      // Xử lý ngoại lệ nếu có lỗi
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy chức năng: " . $e->getMessage(),
      ];
    } finally {
      // Đảm bảo rằng kết nối đóng sau khi hoàn tất
      $this->db = null;
    }
  }
}
