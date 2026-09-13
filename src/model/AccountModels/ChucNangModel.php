<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";


class ChucNangModel {

  private $totalPages = null;

  private $db;

  // View danh sách quyền 
  public function getAllChucNang($page, $search) {
    $query = "SELECT * FROM `ChucNang`";
    $where_clause = "";
    $empty = false;
    $entityPerPage = 20;

    // Lọc theo search
    if (!empty($search)) {
      $empty = false;
      $where_clause .= " WHERE TenChucNang LIKE '%" . $search . "%' ";
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

    $query .= "LIMIT $entityPerPage OFFSET $start_from";

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
      return  (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy danh sách quyền",
      ];
    } finally {
      $this->totalPages = null;
      $this->db = null;
    }
  }
  // Hàm lấy ID dựa vào chức năng
  public function getIdByTenChucNang($TenChucNang) {
    $query = "SELECT MaChucNang FROM `ChucNang` WHERE `TenChucNang` = :tenchucnang";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->bindValue(':tenchucnang', $TenChucNang, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      // Kiểm tra xem có dòng nào được trả về không
      if ($result) {
        return (object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $result,
        ];
      } else {
        return null; // Hoặc trả về một giá trị khác nếu muốn
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

  public function getChucNangByNhieuId($arrayIdChucNang) {
    $query = "SELECT * FROM `ChucNang` WHERE `MaChucNang` IN :machucnang";
    $this->db  = MysqlConfig::getConnection();
    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        $statement->bindValue(':maChucNang', implode(',', $arrayIdChucNang), PDO::PARAM_STR);

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
  // Lấy chức năng theo ID
  public function getChucNangById($maChucNang) {

    $query = "SELECT * FROM `ChucNang` WHERE `MaChucNang` = :maChucNang";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        $statement->bindValue(':maChucNang', $maChucNang, PDO::PARAM_INT);

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
}
