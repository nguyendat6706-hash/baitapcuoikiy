<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";
require_once "$projectRoot/src/model/AccountModels/PhanQuyenModel.php";
class QuyenModel {
  private $totalPages = null;

  private $db;

  private $phanQuyenModel;

  // Hàm khởi tạo của lớp
  public function __construct() {
    $this->phanQuyenModel = new PhanQuyenModel();
  }

  public function KiemTraQuyen($TenQuyen) {
    $query = "SELECT * FROM `Quyen` WHERE TenQuyen = :Tenquyen";
    $this->db = MysqlConfig::getConnection();
    $stmt = $this->db->prepare($query);
    try {
      $stmt->bindValue(":Tenquyen", $TenQuyen, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return (object) [
          "message" => "Quyền đã tồn tại",
          "status" => 200
        ];
      } 
      else if(!$TenQuyen)
      {
        return (object) [
          "message" => "Rong",
          "status" => 500
        ];
      }else {
        return (object) [
          "message" => "Quyền chưa tồn tại",
          "status" => 404
        ];
      }
    } catch (PDOException $e) {
      return (object) [
        "message" => "Không thể lấy danh sách quyền: " . $e->getMessage(),
        "status" => 500
      ];
    }
  }

  // View danh sách quyền 
  public function getAllQuyen($page, $search) {
    $query = "SELECT * FROM `Quyen`";
    $where_clause = "";
    $empty = false;
    $entityPerPage = 3;

    // Lọc theo search
    if (!empty($search)) {
      $empty = false;
      $where_clause .= " WHERE TenQuyen LIKE '%" . $search . "%' ";
    }

    // Thêm các điều kiện lọc vào câu truy vấn
    $query .= $where_clause;


    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    // Tính toán tổng số trang
    if ($this->totalPages === null) {

      // Query dùng để tính tổng số trang của các data trả về
      /* 
                    Substr_replace là lệnh dùng để thay thế chuỗi trong PHP
                    Param 1: $query: Chuỗi cần thay ra
                    Param 2: "COUNT(*)": Chuỗi sẽ được thay vào
                    Param 3: 7: THay thế bắt đầu từ vị trí ký tự 7 (Tính từ 0)
                    Param 4: 1: Thay đúng 1 ký tự 
                        Sample:
                    $query = "SELECT * FROM `Quyen`";
                    $query_total_pages = substr_replace($query, "COUNT(*)", 7, 1);
                    -> $query_total_pages = "SELECT COUNT(*) FROM `Quyen`"

                */
      //fetchColumn ( <Cột thứ n> ) : Lấy row đầu tiên của cột thứ n - 1
      $query_total_pages = substr_replace($query, "COUNT(*)", 7, 1);

      // Chạy lệnh Query để lấy ra tổng trang
      $statement_total_pages = $this->db->prepare($query_total_pages);
      $statement_total_pages->execute();


      $this->totalPages = ceil($statement_total_pages->fetchColumn() / $entityPerPage);
    }

    // Kiểm tra tham số phân trang 

    /*
            $entityPerPage: Số lượng phân tử mỗi trang
            $current_page: Số trang hiện tại
            $start_from: Bắt đầu từ  row thứ bao nhiêu ?

            Giải thích câu truy vấn
                + Offset: Dùng để bỏ qua số lượng row (Chặn đầu trên)
                + Limit giới hạn số row lấy ra (Chặn đầu dưới)
                    -> Kết hợp cả 2 lại ta có công thức phân trang

            */


    $current_page = isset($page) ? $page : 1;
    $start_from = ($current_page - 1) * $entityPerPage;

    $query .= "ORDER BY MaQuyen LIMIT $entityPerPage OFFSET $start_from";

    // Khởi tạo kết nối đến cơ sở dữ liệu

    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return (object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $result,
          "totalPages" => $this->totalPages
        ];
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy danh sách quyền",
      ];
    } finally {
      $this->totalPages = null;
      $this->db = null;
    }
  }
  public function getAllQuyenKhongPhanTrang($search) {
    $query = "SELECT * FROM `Quyen`";
    $where_clause = "";
    // Lọc theo search
    if (!empty($search)) {
      $empty = false;
      $where_clause .= " WHERE TenQuyen LIKE '%" . $search . "%' ";
    }

    // Thêm các điều kiện lọc vào câu truy vấn
    $query .= $where_clause;
    $query .= "ORDER BY MaQuyen";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    // Tính toán tổng số trang
    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {
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
        "message" => "Lỗi không thể lấy danh sách quyền",
      ];
    } finally {
      $this->totalPages = null;
      $this->db = null;
    }
  }


  // Lấy quyền theo ID
  public function getQuyenById($maQuyen) {

    $query = "SELECT * FROM `Quyen` WHERE `MaQuyen` = :maQuyen";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        $statement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

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

  public function createQuyen($tenQuyen, $danhSachChucNang) {

    $query = "INSERT INTO `Quyen` (`TenQuyen`) VALUES (:tenQuyen)";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement  !== false) {
        // Bind giá trị vào tham số :tenQuyen trong câu truy vấn
        $statement->bindValue(':tenQuyen', $tenQuyen, PDO::PARAM_STR);


        // Thực hiện truy vấn
        $statement = $statement->execute();


        if (!empty($danhSachChucNang)) {
          $maQuyen = $this->db->lastInsertId();


          foreach ($danhSachChucNang as $maChucNang) {
            $this->phanQuyenModel->createPhanQuyen($maQuyen, $maChucNang);
          }
        }
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

  public function updateQuyen($maQuyen, $tenQuyen, $danhSachChucNang) {

    $query = "UPDATE `Quyen` SET `TenQuyen` = :tenQuyen WHERE `MaQuyen` = :maQuyen";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement  !== false) {
        // Bind giá trị vào tham số :tenQuyen trong câu truy vấn
        $statement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);

        $statement->bindValue(':tenQuyen', $tenQuyen, PDO::PARAM_STR);

        // Thực hiện truy vấn
        $statement = $statement->execute();

        $deletePhanQuyenCu = $this->phanQuyenModel->deletePhanQuyen($maQuyen);

        if (!empty($danhSachChucNang)) {
          foreach ($danhSachChucNang as $maChucNang) {
            $this->phanQuyenModel->createPhanQuyen($maQuyen, $maChucNang);
          }
        }

        if ($statement && $deletePhanQuyenCu->status === 200) {
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
        "message" => "Lỗi không thể cập nhật quyền",
      ];
    } finally {
      $this->db = null;
    }
  }

  public function deleteQuyen($maQuyen) {

    $preQuery = "UPDATE `TaiKhoan` 
                        SET `MaQuyen` = 2
                        WHERE `MaQuyen` = :maQuyen";
    $query = "DELETE FROM `Quyen` WHERE `MaQuyen` = :maQuyen";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $deletePhanQuyenCu = $this->phanQuyenModel->deletePhanQuyen($maQuyen);

      $preStatement =  $this->db->prepare($preQuery);

      $statement = $this->db->prepare($query);

      if ($statement  !== false && $preStatement !== false && $deletePhanQuyenCu->status === 200) {
        // Bind giá trị vào tham số :tenQuyen trong câu truy vấn
        $preStatement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);

        // Bind giá trị vào tham số :tenQuyen trong câu truy vấn
        $statement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);



        // Thực hiện truy vấn
        $preStatement = $preStatement->execute();
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
}
