<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";

class NhaCungCap {
  private $db;

  public function getAllNhaCungCap($TenNCC = null) {
    try {
      // Base query
      $query = "SELECT * FROM `NhaCungCap` WHERE 1=1"; // 1=1 is a trick to always have a valid WHERE clause

      // Array to store WHERE conditions
      $where_conditions = [];

      // Add conditions based on parameters
      if (!empty($TenNCC)) {
        $where_conditions[] = "`TenNCC` LIKE :TenNCC";
      }

      // Constructing the WHERE clause
      if (!empty($where_conditions)) {
        $query .= " AND " . implode(" AND ", $where_conditions);
      }

      // Prepare the query
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);

      // Bind parameters
      if (!empty($TenNCC)) {
        $statement->bindValue(':TenNCC', "%" . $TenNCC . "%", PDO::PARAM_STR);
      }

      // Execute the query
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      // Return the result
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
        "SQL" => $query // For debugging purposes
      ];
    } catch (PDOException $e) {
      // Return error message if there's an exception
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $e->getMessage(),
        "SQL" => $query // For debugging purposes
      ];
    } finally {
      // Close the database connection
      $this->db = null;
    }
  }

  public function getAllNhaCungCapNoPaging() {
    try {
      // Base query
      $query = "SELECT * FROM `NhaCungCap`"; // 1=1 is a trick to always have a valid WHERE clause

      // Prepare the query
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);

      // Execute the query
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      // Return the result
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result
      ];
    } catch (PDOException $e) {
      // Return error message if there's an exception
      return (object) [
        "status" => 400,
        "message" => "Lỗi: " . $e->getMessage(),
      ];
    } finally {
      // Close the database connection
      $this->db = null;
    }
  }

  public function getByMaNCC($MaNCC) {
    try {
      $query = "SELECT * FROM NhaCungCap WHERE MaNCC = :MaNCC";
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query); // Changed $this->db to $db
      $statement->execute([':MaNCC' => $MaNCC]);
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return (object) [
          "status" => 200,
          "data" => $result
        ];
      } else {
        return (object) [
          "status" => 404,
          "message" => "Không tìm thấy nhà cung cấp với ID đã cho."
        ];
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => $e
      ];
    } finally {
      $this->db = null; // Changed $this->db to $db
    }
  }

  public function createNhaCungCap($TenNCC, $Email, $SoDienThoai) {
    if (!isset($TenNCC) || !isset($Email) || !isset($SoDienThoai)) {
      return (object) [
        "status" => 400,
        "message" => "Error: Thông tin không đầy đủ.",
      ];
    }

    $query =  "INSERT INTO `NhaCungCap` (`TenNCC`, `Email`, `SoDienThoai`) 
            VALUES (:TenNCC, :Email, :SoDienThoai)";
    try {
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);
      if (!isset($statement)) {
        throw new PDOException("Query statement preparation failed.");
      }
      $statement->bindParam(':TenNCC', $TenNCC);
      $statement->bindParam(':Email', $Email);
      $statement->bindParam(':SoDienThoai', $SoDienThoai, PDO::PARAM_STR);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "Thêm nhà cung cấp thành công.",
      ];
    } catch (PDOException $error) {
      return (object) [
        "status" => 400,
        "message" => "Error: " . $error->getMessage(),
      ];
    } finally {
      if ($this->db) {
        $this->db = null;
      }
    }
  }

  public function updateNhaCungCap($MaNCC, $TenNCC, $Email, $SoDienThoai) {
    try {
      $query = "UPDATE NhaCungCap SET TenNCC = :TenNCC, Email = :Email, SoDienThoai = :SoDienThoai WHERE MaNCC = :MaNCC";
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);
      $statement->bindParam(':MaNCC', $MaNCC, PDO::PARAM_INT); // Assuming MaNCC is an integer
      $statement->bindParam(':TenNCC', $TenNCC, PDO::PARAM_STR); // Assuming TenNCC is a string
      $statement->bindParam(':Email', $Email, PDO::PARAM_STR); // Assuming Email is a string
      $statement->bindParam(':SoDienThoai', $SoDienThoai, PDO::PARAM_STR); // Assuming SoDienThoai is a string

      // Execute the statement
      $statement->execute();

      return (object) [
        "status" => 200,
        "message" => "Cập nhật nhà cung cấp thành công."
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => $e
      ];
    } finally {
      $this->db = null;
    }
  }

  public function deleteNhaCungCap($MaNCC) {
    try {
      $query = "DELETE FROM NhaCungCap WHERE MaNCC = :MaNCC";
      $this->db = MysqlConfig::getConnection();
      $statement = $this->db->prepare($query);
      $statement->execute([':MaNCC' => $MaNCC]);
      return (object) [
        "status" => 200,
        "message" => "Xóa nhà cung cấp thành công."
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => $e
      ];
    } finally {
      $this->db = null;
    }
  }
}
