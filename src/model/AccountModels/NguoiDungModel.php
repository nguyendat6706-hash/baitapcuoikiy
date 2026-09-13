<?php


$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";

require_once "$projectRoot/src/config/MysqlConfig.php";
class NguoiDungModel {
  private $totalPages = null;

  private $db;
  public function getRecordNguoiDung($search, $filter_value) {
    if ($search && $filter_value) {
      $sql = "SELECT COUNT(*) as total FROM NguoiDung Where (Hoten LIKE :value_search  OR Email LIKE :value_search ) And  `DoiTuong` = :filtervalue ";
    } else if (!$search && $filter_value) {
      $sql = "SELECT COUNT(*) as total FROM NguoiDung WHERE `DoiTuong` = :filtervalue";
    } else if ($search && !$filter_value) {
      $sql = "SELECT COUNT(*) as total FROM FROM NguoiDung  WHERE  HoTen LIKE :value_search  OR  Email LIKE :email";
    } else {
      $sql = "SELECT COUNT(*) as total FROM NguoiDung";
    }
    $this->db = MysqlConfig::getConnection();

    try {
      $statement = $this->db->prepare($sql);

      if ($statement !== false) {
        if ($search && !$filter_value) {
          $statement->bindValue(":value_search ", "%" . $search . "%", PDO::PARAM_STR);
          $statement->bindValue(":value_search ", "%" . $search . "%", PDO::PARAM_STR);
        } else if ($search && $filter_value) {
          $statement->bindValue(":value_search ", "%" . $search . "%", PDO::PARAM_STR);
          $statement->bindValue(":valueFilter", $filter_value, PDO::PARAM_INT);
          $statement->bindValue(":value_search ", "%" . $search . "%", PDO::PARAM_STR);
        } else if (!$search && $filter_value) {
          $statement->bindValue(":valueFilter", $filter_value, PDO::PARAM_INT);
        }
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $soluongrecord =  $result['total'];
        $tongsotrang = ceil($soluongrecord / 5);
        $this->totalPages = $tongsotrang;

        return (object) [
          "data" => $soluongrecord,
          "totalPage" => $tongsotrang
        ];
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Không thể tìm thấy",
      ];
    } finally {
      $this->db = null;
    }
  }
  public function getFullNguoiDungVer1($page) {
    $query = "SELECT * FROM NguoiDung";
    $songuoidungMoiTrang = 5;
    $this->db = MysqlConfig::getConnection();
    try {
      $query .= " LIMIT " . $songuoidungMoiTrang . " OFFSET " . ($page - 1) * $songuoidungMoiTrang;
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        // if ($value_search && !$filter_value) {
        //   $statement->bindValue(":value_search", "%" . $value_search . "%", PDO::PARAM_STR);
        //   // $statement->bindValue(":email", "%" . $value_search . "%", PDO::PARAM_STR);
        // } else if ($value_search && $filter_value) {
        //   $statement->bindValue(":value_search", "%" . $value_search . "%", PDO::PARAM_STR);
        //   $statement->bindValue(":Quyen", $filter_value, PDO::PARAM_INT);
        //   $statement->bindValue(":email", "%" . $value_search . "%", PDO::PARAM_STR);
        // } else if (!$value_search && $filter_value) {
        //   $statement->bindValue(":Quyen", $filter_value, PDO::PARAM_INT);
        // }
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
          return (object) [
            "status" => 200,
            "message" => "Thành công",
            "data" => $result,
          ];
        } else {
          return (object) [
            "status" => 400,
            "message" => "Không tìm thấy dữ liệu phù hợp.",
          ];
        }
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Không thể tìm thấy",
      ];
    } finally {
      $this->db = null;
    }
  }

public function getFullMaTaiKhoan(){
  $query = "SELECT NguoiDung.MaTaiKhoan From Web2_Database.NguoiDung";
  $this->db = MysqlConfig::getConnection();
  try {
    $statement = $this->db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return (object)[
      "status" => 200,
      "message" =>"thanh cong",
      "data"=>$result
    ];
  } catch (PDOException $e) {
      return (object)[
        "status" => 400,
        "message" => $e
      ];
  }
}

  public function getFullNguoiDung($page, $value_search, $filter_value) {

    $songuoidungMoiTrang = 5;
    if ($value_search && $filter_value) {
      $query = "SELECT * FROM NguoiDung Where (Hoten LIKE :value_search  OR Email LIKE :email) And  `DoiTuong` = :filtervalue";
    } else if (!$value_search && $filter_value) {
      $query = "SELECT * FROM NguoiDung WHERE `DoiTuong` = :filtervalue";
    } else if ($value_search && !$filter_value) {
      $query = "SELECT * FROM NguoiDung  WHERE  HoTen LIKE :value_search  OR  Email LIKE :email";
    } else {
      $query = "SELECT * FROM NguoiDung";
    }
    $this->db = MysqlConfig::getConnection();
    try {
      $query .= " LIMIT " . $songuoidungMoiTrang . " OFFSET " . ($page - 1) * $songuoidungMoiTrang;
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        if ($value_search && !$filter_value) {
          $statement->bindValue(":value_search", "%" . $value_search . "%", PDO::PARAM_STR);
          $statement->bindValue(":email", "%" . $value_search . "%", PDO::PARAM_STR);
        } else if ($value_search && $filter_value) {
          $statement->bindValue(":value_search", "%" . $value_search . "%", PDO::PARAM_STR);
          $statement->bindValue(":filtervalue", $filter_value, PDO::PARAM_STR);
          $statement->bindValue(":email", "%" . $value_search . "%", PDO::PARAM_STR);
        } else if (!$value_search && $filter_value) {
          $statement->bindValue(":filtervalue", $filter_value, PDO::PARAM_STR);
        }
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
          return (object) [
            "status" => 200,
            "message" => "Thành công",
            "data" => $result,
          ];
        } else {
          return (object) [
            "status" => 400,
            "message" => "Không tìm thấy dữ liệu phù hợp.",
          ];
        }
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Không thể tìm thấy",
      ];
    } finally {
      $this->db = null;
    }
  }


  public function getNguoiDungByMaTKClient($maTaiKhoan) {

    $query = "SELECT * FROM TaiKhoan JOIN NguoiDung ON TaiKhoan.`MaTaiKhoan` = NguoiDung.`MaTaiKhoan` join Quyen on Quyen.`MaQuyen` = TaiKhoan.`MaQuyen`
                    WHERE TaiKhoan.`MaTaiKhoan` = :maTaiKhoan";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return (object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $result,
        ];
      } else {
        return (object) [
          "status" => 400,
          "message" => "Loi",
        ];
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

  public function getNguoiDungByMaTK($maNguoiDung) {
    $query = "SELECT * FROM `NguoiDung` WHERE `MaTaiKhoan` = :maTaiKhoan";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {
        // Prepare the SQL statement
        $statement = $this->db->prepare($query);

        if ($statement !== false) {
            // Bind the parameter
            $statement->bindValue(':maTaiKhoan', $maNguoiDung, PDO::PARAM_INT);
            // Execute the query
            $statement->execute();
            // Fetch the result
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            // Check if the result is not empty
            if ($result) {
                return (object) [
                    "status" => 200,
                    "message" => "Thành công",
                    "data" => $result,
                    "maNguoiDung" => $maNguoiDung
                ];
            } else {
                // No user found with the specified ID
                return (object) [
                    "status" => 404,
                    "message" => "Không tìm thấy người dùng",
                    "maNguoiDung" => $maNguoiDung
                ];
            }
        } else {
            // SQL statement preparation failed
            return (object) [
                "status" => 500,
                "message" => "Lỗi chuẩn bị truy vấn",
            ];
        }
    } catch (PDOException $e) {
        // Exception caught during query execution
        return (object) [
            "status" => 500,
            "message" => "Lỗi không thể lấy người dùng: " . $e->getMessage(),
        ];
    } finally {
        // Close the database connection
        $this->db = null;
    }
}




  /* 
         - Một số rèn buộc đầu vào
                + Không được để trống tham số, các trường chuỗi không được để ""; 
                + `Ngay Sinh` phải có dạng "yyyy-MM-dd"
                + `Gioi TInh` thì "Male' or "Female"
                + `Doi Tuong` thì ENUM("KhachHang", "QuanLy", "NhanVien", "CEO")
        */
  public function createNguoiDungForUser(
    $maTaiKhoan,
    $hoTen,
    $ngaySinh,
    $gioiTinh,
    $soDienThoai,
    $email,
    $diaChi,
  ) {
    $query = "INSERT INTO NguoiDung (MaTaiKhoan, HoTen, NgaySinh, GioiTinh, SoDienThoai, Email, DiaChi, DoiTuong) 
                          VALUES (:maTaiKhoan, :hoTen, :ngaySinh, :gioiTinh, :soDienThoai, :email, :diaChi, 'KhachHang')";

    $this->db = MysqlConfig::getConnection();

    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        $statement->bindParam(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
        $statement->bindParam(':hoTen', $hoTen, PDO::PARAM_STR);
        $statement->bindParam(':ngaySinh', $ngaySinh, PDO::PARAM_STR);
        $statement->bindParam(':gioiTinh', $gioiTinh, PDO::PARAM_STR);
        $statement->bindParam(':soDienThoai', $soDienThoai, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':diaChi', $diaChi, PDO::PARAM_STR);

        if ($statement->execute()) {
          return (object) [
            "status" => 200,
            "message" => "Thành công",
          ];
        } else {
          throw new PDOException();
        }
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể tạo người dùng",
        "error" => $e->getMessage() // Fetch the error message
      ];
    } finally {
      $this->db = null;
    }
  }
  public function createNguoiDung(
    $hoTen,
    $ngaySinh,
    $gioiTinh,
    $soDienThoai,
    $email,
    $diaChi,
    $doiTuong
  ) {
    $query = "INSERT INTO `NguoiDung` (`HoTen`, `NgaySinh`, `GioiTinh`, `SoDienThoai`, `Email`, `DiaChi`, `DoiTuong`) 
                      VALUES (:hoTen, :ngaySinh, :gioiTinh, :soDienThoai, :email, :diaChi, :doiTuong)";


    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {

      $statement = $this->db->prepare($query);

      if ($statement !== false) {

        // Bind giá trị vào các tham số trong câu truy vấn
        $statement->bindValue(':hoTen', $hoTen, PDO::PARAM_STR);
        $statement->bindValue(':ngaySinh', $ngaySinh, PDO::PARAM_STR);
        $statement->bindValue(':gioiTinh', $gioiTinh, PDO::PARAM_STR);
        $statement->bindValue(':soDienThoai', $soDienThoai, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':diaChi', $diaChi, PDO::PARAM_STR);
        $statement->bindValue(':doiTuong', $doiTuong, PDO::PARAM_STR);

        // Thực hiện truy vấn
        $result = $statement->execute(); // execute the statement and store the result


        if ($result) {
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



  /*
        
          - Một số rèn buộc đầu vào
                + Không được để trống tham số, các trường chuỗi không được để ""; 
                + `Tên đăng nhập` phải là phiên bản duy nhất
                + `Ngay Sinh` phải có dạng "yyyy-MM-dd"
                + `Gioi TInh` thì "Male' or "Female"
                + `Doi Tuong` thì ENUM("KhachHang", "QuanLy", "NhanVien", "CEO")
        */

  public function updateNguoiDung(
    $maNguoiDung,
    $hoTen,
    $ngaySinh,
    $gioiTinh,
    $soDienThoai,
    $email,
    $diaChi,
    $MaTaiKhoan,
    $DoiTuong
  ) {
    $query = "UPDATE `NguoiDung` 
                    SET 
                      `HoTen` = :hoTen,
                      `NgaySinh` = :ngaySinh,
                      `GioiTinh` = :gioiTinh,
                      `SoDienThoai` = :soDienThoai,
                      `Email` = :email,
                      `DiaChi` = :diaChi,
                      `DoiTuong` = :DoiTuong";

      
          // Nếu MaTaiKhoan được cung cấp, thêm nó vào câu truy vấn
          if (!empty($MaTaiKhoan)) {
              $query .= ", `MaTaiKhoan` = :MaTaiKhoan";
          }
          else{
            $query .= ", `MaTaiKhoan` = NULL";
          }
      
          $query .= " WHERE `MaNguoiDung` = :MaNguoiDung";
      
          // Khởi tạo kết nối
          $this->db = MysqlConfig::getConnection();
      
          try {
              $statement = $this->db->prepare($query);
      
              if ($statement !== false) {
                  // Bind giá trị vào các tham số trong câu truy vấn
                  $statement->bindValue(':MaNguoiDung',  $maNguoiDung, PDO::PARAM_INT);
                  $statement->bindValue(':hoTen', $hoTen, PDO::PARAM_STR);
                  $statement->bindValue(':ngaySinh', $ngaySinh, PDO::PARAM_STR);
                  $statement->bindValue(':gioiTinh', $gioiTinh, PDO::PARAM_STR);
                  $statement->bindValue(':soDienThoai', $soDienThoai, PDO::PARAM_STR);
                  $statement->bindValue(':email', $email, PDO::PARAM_STR);
                  $statement->bindValue(':diaChi', $diaChi, PDO::PARAM_STR);
                  $statement->bindValue(':DoiTuong', $DoiTuong, PDO::PARAM_STR);
                  
                  // Bind MaTaiKhoan nếu được cung cấp
                  if (!empty($MaTaiKhoan)) {
                      $statement->bindValue(':MaTaiKhoan', $MaTaiKhoan, PDO::PARAM_INT);
                  }
      
                  // Thực hiện truy vấn
                  $statement->execute();
      
                  // Kiểm tra xem có bản ghi nào được cập nhật không
                  if ($statement->rowCount() > 0) {
                      return (object) [
                          "status" => 200,
                          "message" => "Thành công",
                      ];
                  } else {
                      // Trả về false nếu không có bản ghi nào được cập nhật
                      return (object) [
                          "status" => 400,
                          "message" => "Không có bản ghi nào được cập nhật",
                      ];
                  }
              } else {
                  // Trả về false nếu câu lệnh prepare không thành công
                  return (object) [
                      "status" => 400,
                      "message" => "Lỗi prepare statement",
                  ];
              }
          } catch (PDOException $e) {
              // Xử lý lỗi PDO
              return (object) [
                  "status" => 400,
                  "message" => "Lỗi PDO: " . $e->getMessage(),
              ];
          } finally {
              // Đóng kết nối
              $this->db = null;
          }

      }
     
  


  public function updateNguoiDungForUser(
    $maTaiKhoan,
    $hoTen,
    $ngaySinh,
    $gioiTinh,
    $soDienThoai,
    $email,
    $diaChi,
  ) {
    $query = "UPDATE `NguoiDung` 
              SET 
                  `HoTen` = :hoTen,
                  `NgaySinh` = :ngaySinh,
                  `GioiTinh` = :gioiTinh,
                  `SoDienThoai` = :soDienThoai,
                  `Email` = :email,
                  `DiaChi` = :diaChi,
                  `DoiTuong` = 'KhachHang'
              WHERE `MaTaiKhoan` = :maTaiKhoan";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        // Bind giá trị vào các tham số trong câu truy vấn
        $statement->bindValue(':maTaiKhoan', $maTaiKhoan, PDO::PARAM_INT);
        $statement->bindValue(':hoTen', $hoTen, PDO::PARAM_STR);
        $statement->bindValue(':ngaySinh', $ngaySinh, PDO::PARAM_STR);
        $statement->bindValue(':gioiTinh', $gioiTinh, PDO::PARAM_STR);
        $statement->bindValue(':soDienThoai', $soDienThoai, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':diaChi', $diaChi, PDO::PARAM_STR);

        // Thực hiện truy vấn
        $statement->execute();

        // Kiểm tra xem có bản ghi nào được cập nhật không
        if ($statement->rowCount() > 0) {
          return (object) [
            "status" => 200,
            "message" => "Thành công",
          ];
        } else {
          // Trả về false nếu không có bản ghi nào được cập nhật
          return (object) [
            "status" => 404,
            "message" => "Không tìm thấy bản ghi để cập nhật",
          ];
        }
      } else {
        // Trả về false nếu không thể chuẩn bị câu truy vấn
        return (object) [
          "status" => 500,
          "message" => "Lỗi trong quá trình chuẩn bị câu truy vấn",
        ];
      }
    } catch (PDOException $e) {
      // Xử lý lỗi PDO nếu có
      return (object) [
        "status" => 500,
        "message" => $e->getMessage(),
      ];
    }
  }

  public function GoTaiKhoan($maNguoiDung) {
    $query = "UPDATE nguoidung set MaTaiKhoan = null  where MaNguoiDung=:MaNguoiDung";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        $statement->bindValue(':MaNguoiDung', $maNguoiDung, PDO::PARAM_INT);
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

  public function getMaTkByIdNguoiDung($maNguoiDung) {
    $query = "SELECT `maTaiKhoan` FROM `NguoiDung` WHERE `MaNguoiDung` = :maNguoidung";
    $this->db = MysqlConfig::getConnection();

    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        $statement->bindValue(':maNguoidung', $maNguoiDung, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
          return $result['maTaiKhoan'];
        } else {
          // Trả về false nếu không có kết quả
          return false;
        }
      } else {
        // Trả về false nếu không prepare được statement
        return false;
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
  public function setAllowTaiKhoan($maTaiKhoan) {
    $query = "UPDATE TaiKhoan SET isAllow = 1 WHERE MaTaiKhoan = :maTaiKhoan";

    try {
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
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

  public function deleteNguoiDung($maNguoiDung) {
    $query1 = "DELETE FROM `NguoiDung` WHERE `MaNguoiDung` = :maNguoiDung";
    $maTaiKhoan = $this->getMaTkByIdNguoiDung($maNguoiDung);
    $this->setAllowTaiKhoan($maTaiKhoan);
    print_r($maTaiKhoan);
    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {
      // $maTaiKhoan = $this->getMaTkByIdNguoiDung($maNguoiDung);
      $statement1 = $this->db->prepare($query1);

      if ($statement1 !== false) {
        $statement1->bindValue(':maNguoiDung', $maNguoiDung, PDO::PARAM_INT);
        $statement1->execute();
        // Kiểm tra xem cả hai truy vấn đều thành công
        if ($statement1->rowCount() > 0) {
          // Trả về thông báo thành công
          return (object) [
            "status" => 200,
            "message" => "Xóa người dùng thành công",
          ];
        } else {
          // Trả về false nếu không thành công
          throw new PDOException();
        }
      } else {
        // Trả về false nếu không prepare được truy vấn SQL
        throw new PDOException();
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


  public function checkEmail($Email) {
    $query = " SELECT * FROM NGUOIDUNG WHERE EMAIL =:email";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      if ($statement) {
        $statement->bindValue(":email", $Email, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
          return (object)[
            "status" => 200,
            "message" => "Email phù hợp"
          ];
        } else {
          return (object)[
            "status" => 404,
            "message" => "Email ko phù hợp"
          ];
        }
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể truy cập database",
      ];
    } finally {
      $this->db = null;
    }
  }

  public function getUserByEmail($email) {
    // Kiểm tra xem $email có tồn tại không
    if (!isset($email)) {
      return (object) [
        "status" => 400,
        "message" => "Email không được để trống"
      ];
    }

    // Chuẩn bị truy vấn SQL để lấy người dùng dựa trên email
    $query = "SELECT * FROM `NguoiDung` WHERE `Email` = :email";

    // Khởi tạo kết nối đến cơ sở dữ liệu
    $this->db = MysqlConfig::getConnection();

    try {
      // Chuẩn bị và thực thi truy vấn SQL
      $statement = $this->db->prepare($query);
      $statement->bindParam(':email', $email, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      // Kiểm tra xem có kết quả trả về không
      if ($result) {
        return (object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $result,
        ];
      } else {
        // Trả về thông báo lỗi nếu không tìm thấy người dùng
        return (object) [
          "status" => 404,
          "message" => "Không tìm thấy người dùng",
        ];
      }
    } catch (\Throwable $th) {
      // Xử lý ngoại lệ và trả về thông báo lỗi
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $th->getMessage()
      ];
    } finally {
      // Đảm bảo đóng kết nối với cơ sở dữ liệu
      if ($this->db) {
        $this->db = null;
      }
    }
  }
}
