<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";


if (isset($_GET['action'])) {

  $model = new InventoryModel();

  if ($_GET['action'] == "fetch") {

    $page = $_GET['page'];
    $date = $_GET['date'];
    $sort = $_GET['sort'];
    if ($date == "") {
      $date = null;
    }

    $result = $model->getAllPhieuNhapKhoPaging($page, $date, $sort);

    echo json_encode($result);
  }
}




class InventoryModel {
  private $db;

  public function __construct() {
    $this->db = MysqlConfig::getConnection();
  }

  public function getAllPhieuNhapKhoPaging($page, $datenhapkho, $sort) {
    $elementPerPage = 5;

    $this->db = MysqlConfig::getConnection();
    $query = "SELECT MaPhieu, NgayNhapKho, pnk.MaNCC, TongGiaTri, pnk.MaQuanLy, TenNCC, nguoidung.HoTen as TenQuanLy 
                    FROM PhieuNhapKho AS pnk 
                    JOIN nhacungcap ON pnk.MaNCC = nhacungcap.MaNCC 
                    JOIN taikhoan AS tk ON pnk.MaQuanLy = tk.MaTaiKhoan 
                    JOIN NguoiDung ON tk.MaTaiKhoan = NguoiDung.MaNguoiDung";

    // Xây dựng điều kiện WHERE dựa trên ngày nhập kho nếu có
    $where_conditions = [];
    if ($datenhapkho !== null && $datenhapkho !== "") {
      $where_conditions[] = "NgayNhapKho LIKE :NgayNhapKho";
    }

    // Thêm các điều kiện WHERE vào truy vấn nếu có
    if (!empty($where_conditions)) {
      $query .= " WHERE " . implode(" AND ", $where_conditions);
    }

    // sort
    switch ($sort) {
      case 'MaPhieuASC':
        $query .= " ORDER BY MaPhieu ASC";
        break;
      case 'MaPhieuDESC':
        $query .= " ORDER BY MaPhieu DESC";
        break;
      case 'NgayNhapKhoASC':
        $query .= " ORDER BY NgayNhapKho ASC";
        break;
      case 'NgayNhapKhoDESC':
        $query .= " ORDER BY NgayNhapKho DESC";
        break;
      case 'TongGiaTriASC':
        $query .= " ORDER BY TongGiaTri ASC";
        break;
      case 'TongGiaTriDESC':
        $query .= " ORDER BY TongGiaTri DESC";
        break;
      default:
        // Mặc định sắp xếp theo MaPhieu
        $query .= " ORDER BY pnk.`MaPhieu` ASC";
        break;
    }

    // Truy vấn để tính tổng số lượng bản ghi
    $query_total_row = "SELECT COUNT(*) AS totalRows FROM (" . $query . ") AS subquery";
    $statement_total_row = $this->db->prepare($query_total_row);
    if ($datenhapkho !== null && $datenhapkho !== "") {
      $statement_total_row->execute([':NgayNhapKho' => '%' . $datenhapkho . '%']);
    } else {
      $statement_total_row->execute();
    }
    $totalRows = $statement_total_row->fetchColumn();
    $totalPages = ceil($totalRows / $elementPerPage);

    // Thêm LIMIT và OFFSET vào truy vấn
    $start_from = ($page - 1) * $elementPerPage;
    $query .= " LIMIT $elementPerPage OFFSET $start_from";
    try {
      $statement = $this->db->prepare($query);
      if ($datenhapkho !== null && $datenhapkho !== "") {
        $statement->execute([':NgayNhapKho' => '%' . $datenhapkho . '%']);
      } else {
        $statement->execute();
      }
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
        "message" => "Lỗi không thể lấy danh sách nhập kho: " . $e->getMessage(),
      ];
    }
  }

  public function getAllPhieuNhapKhoNoPaging() {
    try {
      $sql = "SELECT * FROM `PhieuNhapKho`";
      $stmt = $this->db->query($sql);
      return (object) [
        "status" => 200,
        "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
      ];
    } catch (PDOException $error) {
      return (object) [
        "status" => 400,
        "message" => "Error: " . $error->getMessage()
      ];
    }
  }

  public function getPhieuNhapKhoById($id) {
    try {
      $sql = "SELECT * FROM `PhieuNhapKho` JOIN `NguoiDung` ON `NguoiDung`.`MaNguoiDung` = `PhieuNhapKho`.`MaQuanLy` WHERE `MaPhieu` = :id;";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([':id' => $id]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return (object) [
          "status" => 200,
          "data" => $result
        ];
      } else {
        return (object) [
          "status" => 404,
          "message" => "Không tìm thấy phiếu nhập kho với ID đã cho."
        ];
      }
    } catch (PDOException $error) {
      return (object) [
        "status" => 400,
        "message" => "Error: " . $error->getMessage()
      ];
    }
  }

  public function createPhieuNhapKho($TongGiaTri, $MaNCC, $MaQuanLy) {
    if (empty($TongGiaTri) || empty($MaNCC) || empty($MaQuanLy)) {
      return (object) [
        "status" => 400,
        "message" => "Error: Thông tin không đầy đủ."
      ];
    }

    try {
      $query = "INSERT INTO PhieuNhapKho (TongGiaTri, MaNCC, MaQuanLy) 
                    VALUES (:TongGiaTri, :MaNCC, :MaQuanLy)";
      $stmt = $this->db->prepare($query);
      $stmt->execute([
        ':TongGiaTri' => $TongGiaTri,
        ':MaNCC' => $MaNCC,
        ':MaQuanLy' => $MaQuanLy
      ]);
      $newID = $this->db->lastInsertId();
      return (object) [
        "status" => 200,
        "message" => "Thêm phiếu nhập kho thành công.",
        "id" => $newID
      ];
    } catch (PDOException $error) {
      return (object) [
        "status" => 400,
        "message" => "Error: " . $error->getMessage()
      ];
    }
  }
}
