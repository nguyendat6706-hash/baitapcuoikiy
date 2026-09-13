<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";

class TaiKhoanModel {
  private $totalPages = null;

  private $nguoiDungModel;

  private $db;

  // Hàm khởi tạo của lớp
  public function __construct() {
    $this->nguoiDungModel = new NguoiDungModel();
  }


  public function getAllTaiKhoan($page, $search, $filter,$trangthai) {
    $query = "SELECT * FROM `TaiKhoan` JOIN `Quyen` ON `TaiKhoan`.`MaQuyen` = `Quyen`.`MaQuyen`";
    $where_clause = "";
    $entityPerPage = 5;

    // Lọc theo search
    if (!empty($search)) {
      $where_clause .= " WHERE `TenDangNhap` LIKE '%" . $search . "%' ";
    }
    // Lọc theo filter
    if (!empty($filter)) {
      $where_clause .= ($where_clause ? " AND" : " WHERE") . " `TaiKhoan`.`MaQuyen` = " . $filter;
    }
    if (!empty($trangthai)) {
      $where_clause .= ($where_clause ? " AND" : " WHERE") . " `TaiKhoan`.`trangthai` = " . $trangthai;
    }
    if($trangthai==0){
      $where_clause .= ($where_clause ? " AND" : " WHERE") . " `TaiKhoan`.`trangthai` = " . 0;
    }

    // Thêm điều kiện lọc vào câu truy vấn
    $query .= $where_clause;

    // Thêm điều kiện sắp xếp
    $query .= " ORDER BY MaTaiKhoan ASC";
    

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    // Tính toán tổng số trang nếu cần
    $totalPages = $this->getTotalPages($entityPerPage, $query, $filter);

    // Kiểm tra tham số phân trang 
    $current_page = isset($page) ? $page : 1;
    $start_from = ($current_page - 1) * $entityPerPage;
    $query .= " LIMIT $entityPerPage OFFSET $start_from";

    // Thực thi câu truy vấn
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
        "totalPages" => $totalPages
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy danh sách tài khoản",
      ];
    } finally {
      $this->db = null;
    }
  }
  private function getTotalPages($entityPerPage, $query, $filter) {
    if ($this->totalPages === null) {
      // Query dùng để tính tổng số trang của các data trả về
      $query_total_pages = substr_replace($query, "COUNT(*)", 7, 1);

      // Thêm điều kiện lọc vào câu truy vấn nếu có filter

      // Chạy lệnh Query để lấy ra tổng trang
      $statement_total_pages = $this->db->prepare($query_total_pages);
      $statement_total_pages->execute();
      $this->totalPages = ceil($statement_total_pages->fetchColumn() / $entityPerPage);
    }
    return $this->totalPages;
  }
  public function setAllowTaiKhoan($maTaiKhoan, $value) {
    $query = "UPDATE TaiKhoan SET isAllow = :trangthai WHERE MaTaiKhoan = :maTaiKhoan";

    try {
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        $statement->bindValue(':trangthai', $value, PDO::PARAM_INT);
        $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);

        $statement->execute();

        return (object) [
          "status" => 200,
          "message" => "Thành công",
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
  public function HienThiDanhSachTaiKhoan() {
    $query = "SELECT * FROM `TaiKhoan` where isAllow = 1 and trangthai = 1";
    $query .= " ORDER BY MaTaiKhoan ASC"; // Added a space before "ORDER BY" and capitalized "ASC"
    $this->db = MysqlConfig::getConnection();
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
        "message" => $e,
      ];
    } finally {
      $this->totalPages = null;
      $this->db = null;
    }
  }
  public function getAllTaiKhoanWithoutPagination($search) {
    $query = "SELECT * FROM `TaiKhoan` JOIN `Quyen` ON `TaiKhoan`.`MaQuyen` = `Quyen`.`MaQuyen`";
    $where_clause = "";
    // Lọc theo search
    if (!empty($search)) {
      $empty = false;
      $where_clause .= " WHERE `TenDangNhap` LIKE '%" . $search . "%' ";
    }
    $query .= $where_clause;
    $query .= "order by MaTaiKhoan asc";
    $this->db = MysqlConfig::getConnection();

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
        ];
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy danh sách tài khoản",
      ];
    } finally {
      $this->totalPages = null;
      $this->db = null;
    }
  }

  public function getTaiKhoanById($maTaiKhoan) {

    $query = "SELECT * FROM `TaiKhoan` WHERE `MaTaiKhoan` = :maTaiKhoan";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);

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



  /*
            - Các trường còn thiếu và tại sao không truyền vào ?
                + Trạng thái: Tự set là hợp lệ
                + Ngày tạo: Tự động spawn ra thời gian hiện tại
            - Một số rèn buộc đầu vào
                + Không được để trống tham số, các trường chuỗi không được để ""; 
                + `Tên đăng nhập` phải là phiên bản duy nhất
                + `Ngay Sinh` phải có dạng "yyyy-MM-dd"
                + `Gioi TInh` thì "Male' or "Female"
                + `Doi Tuong` thì ENUM("KhachHang", "QuanLy", "NhanVien", "CEO")
        */


  public function createTaiKhoanHeThong(
    $tenDangNhap,
    $matKhau,
    $maQuyen,
  ) {
    $query = "INSERT INTO `TaiKhoan` (`TenDangNhap`, `MatKhau`, `MaQuyen`,`isAllow`) 
          VALUES (:tenDangNhap, :matKhau, :maQuyen,1)";
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);
      if ($statement  !== false) {
        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':tenDangNhap', $tenDangNhap,        PDO::PARAM_STR);
        $statement->bindValue(':matKhau', $matKhau,            PDO::PARAM_STR);
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
        "message" => $e->getMessage(),
      ];
    } finally {
      $this->db = null;
    }
  }


  public function createTaiKhoan(
    $tenDangNhap,
    $matKhau,
    $maQuyen,
    $hoTen,
    $ngaySinh,
    $gioiTinh,
    $soDienThoai,
    $email,
    $diaChi,
  ) {

    $query = "INSERT INTO `TaiKhoan` (`TenDangNhap`, `MatKhau`, `MaQuyen`,`isAllow`) 
                        VALUES (:tenDangNhap, :matKhau, :maQuyen, 1)";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);


      if ($statement  !== false) {

        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':tenDangNhap', $tenDangNhap,        PDO::PARAM_STR);
        $statement->bindValue(':matKhau', $matKhau,            PDO::PARAM_STR);
        $statement->bindValue(':maQuyen', $maQuyen,            PDO::PARAM_INT);


        // Thực hiện truy vấn
        $statement = $statement->execute();

        $userId = $this->db->lastInsertId();
        //  Sau khi tạo xong thì ta sẽ bắt đầu tạo người dùng
        $subResult = $this->nguoiDungModel->createNguoiDungForUser(
          $userId,
          $hoTen,
          $ngaySinh,
          $gioiTinh,
          $soDienThoai,
          $email,
          $diaChi
        );


        if ($statement && $subResult->status === 200) {
          // Trả về ID của bản ghi vừa chèn
          return (object) [
            "status" => 200,
            "message" => "Thành công",
          ];
        } else {
          return (object)[
            "status" => 400,
            "message" => "Lỗi không thể tạo người dùng"
          ];
        }
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể tạo quyền",
        "error" => $e->getMessage()
      ];
    } finally {
      $this->db = null;
    }
  }

  public function updateTaiKhoanHeThong($maTaiKhoan, $tenDangNhap, $matKhau, $maQuyen) {
    $query = "UPDATE `TaiKhoan` SET 
                    `MaQuyen`     = :maQuyen,
                    `TenDangNhap` = :tendangnhap,
                    `matkhau`     = :matkhau
                     WHERE `MaTaiKhoan` = :maTaiKhoan";

    $this->db = MysqlConfig::getConnection();

    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
        $statement->bindValue(':tendangnhap', $tenDangNhap, PDO::PARAM_STR);
        $statement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);
        $statement->bindValue(':matkhau', $matKhau, PDO::PARAM_STR);

        // Thực hiện truy vấn
        $result = $statement->execute();

        if ($result) {
          // Trả về ID của bản ghi vừa chèn
          return (object) [
            "status"  => 200,
            "message" => "Thành công",
          ];
        } else {
          // Trả về false nếu không thành công
          throw new PDOException();
        }
      }
    } catch (PDOException $e) {
      return (object) [
        "status"  => 400,
        "message" => "Lỗi không thể cập nhật tài khoản",
      ];
    } finally {
      $this->db = null;
    }
  }
  public function updateTaiKhoan(
    $maTaiKhoan,
    $trangThai,
    $maQuyen,
    $hoTen,
    $ngaySinh,
    $gioiTinh,
    $soDienThoai,
    $email,
    $diaChi,
    $doiTuong
  ) {

    $query = "UPDATE `TaiKhoan` SET 
                    `MaQuyen`     = :maQuyen,
                    `TrangThai`   = :trangThai
                     WHERE `MaTaiKhoan` = :maTaiKhoan";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement  !== false) {
        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
        $statement->bindValue(':trangThai', $trangThai, PDO::PARAM_INT);
        $statement->bindValue(':maQuyen', $maQuyen, PDO::PARAM_INT);


        // Thực hiện truy vấn
        $statement = $statement->execute();

        $subStatement =  $this->nguoiDungModel->updateNguoiDung(
          $maTaiKhoan,
          $hoTen,
          $ngaySinh,
          $gioiTinh,
          $soDienThoai,
          $email,
          $diaChi,
          $maQuyen,
          $doiTuong
        );


        if ($statement && $subStatement->status === 200) {
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
        "message" => "Lỗi không thể cập nhật tài khoản",
      ];
    } finally {
      $this->db = null;
    }
  }

  public function BlockorUnblockTaiKhoan($maTaiKhoan, $state) {
    $query = "UPDATE `TaiKhoan` SET TRANGTHAI = :trangthai WHERE `MaTaiKhoan` = :maTaiKhoan";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement  !== false) {
        // Bind giá trị vào tham số :tenTaiKhoan trong câu truy vấn
        $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
        $statement->bindValue(':trangthai', $state, PDO::PARAM_INT);
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



  public function checkTaiKhoanExits($tenTaiKhoan) {
    try {
      $this->db = MysqlConfig::getConnection();
      if (!$this->db) {
        throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
      }
      $query = "SELECT TENDANGNHAP FROM TAIKHOAN WHERE TENDANGNHAP = :tentaikhoan";
      $statement = $this->db->prepare($query);

      if ($statement) {
        $statement->bindValue(":tentaikhoan", $tenTaiKhoan, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
          return (object)[
            "status" => 200,
            "message" => "Không có tài khoản tồn tại, có thể dùng để đăng ký",
          ];
        } else {
          return (object) [
            "status" => 404,
            "message" => "Tài khoản tồn tại"
          ];
        }
      } else {
        // Trả về false nếu không thành công
        throw new Exception("Lỗi trong quá trình chuẩn bị câu lệnh SQL");
      }
    } catch (Exception $e) {
      return [
        "status" => 400,
        "message" => $e->getMessage(),
      ];
    } finally {
      $this->db = null;
    }
  }

  public function getUserByUsername($username) {
    if (!isset($username)) {
      return (object) [
        "status" => 400,
        "message" => "Tên đăng nhập không được để trống"
      ];
    }

    $query = "SELECT * FROM `TaiKhoan` WHERE `TenDangNhap` = :username";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->bindParam(':username', $username, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      if ($result) {
        return (object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $result,
        ];
      } else {
        return (object) [
          "status" => 404,
          "message" => "Không tìm thấy người dùng",
        ];
      }
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
