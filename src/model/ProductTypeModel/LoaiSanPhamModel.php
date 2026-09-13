<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";

class LoaiSanPham
{
  private $db;


  # TODO: section search is missing(require)
  public function getAllTypeProduct($page, $search)
  {
    $query = "SELECT * FROM `LoaiSanPham`";
    $where_clause = "";
    $empty = false;
    $entityPerPage = 20;

    // Filter by search
    if (!empty($search)) {
      $empty = true;
      $where_clause .= " WHERE TenLoaiSanPham LIKE '%" . $search . "%' ";
    }

    // Add filter conditions to the query
    $query .= $where_clause;

    // Initialize database connection
    $this->db = MysqlConfig::getConnection();

    // Prepare query to get total pages
    $query_total_pages = substr_replace($query, "COUNT(*)", 7, 1);
    $statement_total_pages = $this->db->prepare($query_total_pages);
    $statement_total_pages->execute();
    $totalPages = ceil($statement_total_pages->fetchColumn() / $entityPerPage);

    // Check pagination parameters
    $current_page = isset($page) ? $page : 1;
    $start_from = ($current_page - 1) * $entityPerPage;

    $query .= " LIMIT $entityPerPage OFFSET $start_from";

    // Initialize database connection
    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return (object) [
          "status" => 200,
          "message" => "Success",
          "data" => $result,
          "totalPages" => $totalPages
        ];
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return  (object) [
        "status" => 400,
        "message" => "Error: Unable to retrieve the list of product types",
      ];
    } finally {
      $this->db = null;
    }
  }


  # TODO: section search is missing(require)
  public function getAllTypeProductNoPaging()
  {
    $query = "SELECT * FROM `LoaiSanPham`";

    // Initialize database connection
    $this->db = MysqlConfig::getConnection();


    // Initialize database connection
    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return (object) [
          "status" => 200,
          "message" => "Success",
          "data" => $result
        ];
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return  (object) [
        "status" => 400,
        "message" => "Error: Unable to retrieve the list of product types",
      ];
    } finally {
      $this->db = null;
    }
  }

  // Hàm lấy ID dựa vào chức năng
  public function getIdByTenChucNang($TenChucNang)
  {
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

  public function getTypeProductById($productId)
  {
    $query = "SELECT * FROM LoaiSanPham WHERE id = :id";
    try {
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);
      if (!isset($statement)) {
        throw new PDOException("Query statement preparation failed.");
      }
      $statement->bindParam(':id', $productId);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $error) {
      return ((object)[
        "status" => 400,
        "message" => "Error: " . $error->getMessage(),
      ]);
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }


  # TODO: need to check code and just put the name behind ":" if code is ok : HUY
  public function createTypeProduct($tenLoaiSanPham)
  {
    if (empty($tenLoaiSanPham)) {
      return ((object)[
        "status" => 400,
        "message" => "Error: Tên loại sản phẩm không được cung cấp."
      ]);
    }
    $query = "
        INSERT INTO LoaiSanPham (TenLoaiSanPham)
        VALUES ('$tenLoaiSanPham');
    ";

    try {
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);
      if (!isset($statement)) {
        throw new PDOException("Query statement preparation failed.");
      }
      $statement->execute();

      return ((object)[
        "status" => 200,
        "message" => "Thêm loại sản phẩm thành công."
      ]);
    } catch (PDOException $error) {
      return ((object)[
        "status" => 400,
        "message" => "Error: " . $error->getMessage()
      ]);
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }

  # TODO: need to check code and just put the name behind ":" if code is ok : HUY
  public function deleteTypeProduct($maLoaiSanPham)
  {
    if (!isset($maLoaiSanPham)) {
      return ((object)[
        "status" => 400,
        "message" => "Error: Mã loại sản phẩm không được cung cấp."
      ]);
    } else {
      $query = "
        DELETE FROM `LoaiSanPham` WHERE MaLoaiSanPham = " . $maLoaiSanPham;
      $updatequery = "
          UPDATE `SanPham` SET MaLoaiSanPham = 1 WHERE MaLoaiSanPham = $maLoaiSanPham
    ";
      try {
        $this->db = MysqlConfig::getConnection();
        $updatestatement = $this->db->prepare($updatequery);
        if (!isset($updatestatement)) {
          throw new PDOException("Query statement preparation failed.");
        }
        $updatestatement->execute();

        $statement = $this->db->prepare($query);
        if (!isset($statement)) {
          throw new PDOException("Query statement preparation failed.");
        }
        $statement->execute();

        // Trả về thông báo thành công khi xóa loại sản phẩm
        return ((object)[
          "status" => 200,
          "message" => "Xóa loại sản phẩm thành công."
        ]);
      } catch (PDOException $th) {
        return ((object)[
          "status" => 400,
          "message" => "Error: " . $th->getMessage()
        ]);
      } finally {
        if ($this->db) {
          $this->db = null;
        }
      }
    }
  }

  # TODO: need to check code and just put the name behind ":" if code is ok : HUY
  public function updateTypeProduct($maLoaiSanPham, $tenLoaiSanPham)
  {
    if (empty($maLoaiSanPham) || empty($tenLoaiSanPham)) {
      return ((object)[
        "status" => 400,
        "message" => "Error: Mã loại sản phẩm hoặc tên loại sản phẩm không được cung cấp."
      ]);
    }
    $query = "
          UPDATE `LoaiSanPham` SET TenLoaiSanPham = '$tenLoaiSanPham' WHERE MaLoaiSanPham = $maLoaiSanPham
    ";
    try {
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);
      if (!isset($statement)) {
        throw new PDOException("Query statement preparation failed.");
      }
      $statement->execute();

      return ((object)[
        "status" => 200,
        "message" => "Cập nhật loại sản phẩm thành công."
      ]);
    } catch (\Throwable $th) {
      return ((object)[
        "status" => 400,
        "message" => "Error: " . $th->getMessage()
      ]);
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }
}
// Check if the request is an AJAX request
