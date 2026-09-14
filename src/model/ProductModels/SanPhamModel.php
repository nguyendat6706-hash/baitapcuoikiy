<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";
class ProductModel {

  private $db;

  public function getAllProducts($page, $search, $theTich, $minGia, $maxGia, $minNongDoCon, $maxNongDoCon, $brand, $origin, $maLoaiSanPham) {
    // Khởi tạo câu truy vấn
    $query = "SELECT * FROM `SanPham` WHERE Trangthai = 1";

    // Tạo mảng để lưu trữ các điều kiện WHERE
    $where_conditions = [];

    // Thêm điều kiện tìm kiếm
    if (isset($search)) {
      $where_conditions[] = "TenSanPham LIKE '%$search%'";
    }

    // Thêm điều kiện về thể tích
    if (isset($theTich)) {
      $where_conditions[] = "TheTich <= $theTich";
    }

    // Thêm điều kiện về giá
    if (isset($minGia) && isset($maxGia)) {
      $where_conditions[] = "Gia BETWEEN $minGia AND $maxGia";
    }

    // Thêm điều kiện về nồng độ chất còn lại
    if (isset($minNongDoCon) && isset($maxNongDoCon)) {
      $where_conditions[] = "NongDoCon BETWEEN $minNongDoCon AND $maxNongDoCon";
    }

    // Thêm điều kiện về thương hiệu
    if (isset($brand)) {
      $where_conditions[] = "ThuongHieu = '$brand'";
    }

    // Thêm điều kiện về xuất xứ
    if (isset($origin)) {
      $where_conditions[] = "XuatXu = '$origin'";
    }

    // Thêm điều kiện về mã loại sản phẩm
    if (isset($maLoaiSanPham)) {
      $where_conditions[] = "MaLoaiSanPham = '$maLoaiSanPham'";
    }

    // Kiểm tra xem có điều kiện WHERE nào không
    if (!empty($where_conditions)) {
      $query .= " AND " . implode(" AND ", $where_conditions);
    }

    // Khởi tạo kết nối đến cơ sở dữ liệu
    $this->db = MysqlConfig::getConnection();
    try {
      // Thêm câu truy vấn để lấy tổng số sản phẩm từ câu truy vấn chính
      $count_query = "SELECT COUNT(*) FROM ($query) AS total_items";
      $statement_total_items = $this->db->prepare($count_query);
      $statement_total_items->execute();
      $total_items = $statement_total_items->fetchColumn();

      // Tính tổng số trang dựa trên số lượng sản phẩm và số sản phẩm mỗi trang
      $items_per_page = 8; // Số sản phẩm trên mỗi trang
      $total_pages = ceil($total_items / $items_per_page);

      // Xác định trang hiện tại và vị trí bắt đầu
      $current_page = isset($page) ? $page : 1;
      $start_from = ($current_page - 1) * $items_per_page;

      // Thêm phần giới hạn số lượng và vị trí bắt đầu vào câu truy vấn
      $query .= " LIMIT $start_from,$items_per_page";

      // Thực hiện truy vấn chính và trả về kết quả
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      // Trả về kết quả
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
        "totalPages" => $total_pages,
        "SQL" => $query
      ];
    } catch (PDOException $e) {
      // Trả về thông báo lỗi nếu có lỗi xảy ra
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy sản phẩm",
        "SQL" => $query,
      ];
    } finally {
      // Đóng kết nối với cơ sở dữ liệu
      $this->db = null;
    }
  }

  public function getAllProductsNoPagingForInventoryView($search) {
    // Khởi tạo câu truy vấn
    $query = "SELECT * FROM `SanPham`";


    // Thêm điều kiện tìm kiếm
    if (!empty($search)) {
      $query .= " WHERE `TenSanPham` LIKE '%$search%'";
    }


    // Khởi tạo kết nối đến cơ sở dữ liệu
    $this->db = MysqlConfig::getConnection();
    try {
      // Thực hiện truy vấn chính và trả về kết quả
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      // Trả về kết quả
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result
      ];
    } catch (PDOException $e) {
      // Trả về thông báo lỗi nếu có lỗi xảy ra
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy sản phẩm",
        "SQL" => $query,
      ];
    } finally {
      // Đóng kết nối với cơ sở dữ liệu
      $this->db = null;
    }
  }

  public function getProductById($productId) {
    // Khởi tạo câu truy vấn
    $query = "SELECT SanPham.*, LoaiSanPham.TenLoaiSanPham
              FROM `SanPham`
              INNER JOIN `LoaiSanPham` ON SanPham.MaLoaiSanPham = LoaiSanPham.MaLoaiSanPham
              WHERE SanPham.MaSanPham = :productId";

    // Khởi tạo kết nối đến cơ sở dữ liệu
    $this->db = MysqlConfig::getConnection();
    try {
      // Thực hiện truy vấn và truyền tham số
      $statement = $this->db->prepare($query);
      $statement->bindParam(':productId', $productId);
      $statement->execute();
      $product = $statement->fetch(PDO::FETCH_ASSOC);

      // Kiểm tra xem có sản phẩm nào được trả về không
      if ($product) {
        // Trả về kết quả nếu sản phẩm tồn tại
        return ((object) [
          "status" => 200,
          "message" => "Thành công",
          "data" => $product
        ]);
      } else {
        // Trả về thông báo nếu không tìm thấy sản phẩm
        return ((object) [
          "status" => 404,
          "message" => "Không tìm thấy sản phẩm",
        ]);
      }
    } catch (PDOException $e) {
      // Trả về thông báo lỗi nếu có lỗi xảy ra
      return ((object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy thông tin sản phẩm",
      ]);
    } finally {
      // Đóng kết nối với cơ sở dữ liệu
      $this->db = null;
    }
  }


  public function updateTangSoLuong($maSanPham, $soLuong) {

    // Chuẩn bị câu truy vấn
    $query = "UPDATE `SanPham` SET `SoLuongConLai` = `SoLuongConLai` + :soLuongTang WHERE `MaSanPham` = :maSanPham";

    // Khởi tạo kết nối
    $this->db = MysqlConfig::getConnection();

    try {
      $statement = $this->db->prepare($query);

      if ($statement !== false) {
        $statement->bindValue(':soLuongTang', $soLuong, PDO::PARAM_INT);
        $statement->bindValue(':maSanPham', $maSanPham, PDO::PARAM_INT);

        $statement->execute();

        return (object) [
          "status" => 200,
          "message" => "Tăng số lượng sản phẩm thành công!"
        ];
      } else {
        throw new PDOException();
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể tăng số lượng sản phẩm"
      ];
    } finally {
      $this->db = null;
    }
  }

  public function createProduct($tenSP, $theTich, $gia, $nongDoCon, $xuatXu, $thuongHieu, $anhMinhHoa, $maLoaiSanPham, $moTa) {
    if (!isset($tenSP) || !isset($theTich) || !isset($gia) || !isset($nongDoCon) || !isset($xuatXu) || !isset($thuongHieu) || !isset($anhMinhHoa) || !isset($maLoaiSanPham)) {
      return (object) [
        "status" => 400,
        "message" => "Missing required fields",
      ];
    }

    // Khởi tạo kết nối đến cơ sở dữ liệu
    $this->db = MysqlConfig::getConnection();
    try {
      // Chuẩn bị câu lệnh SQL với tham số
      $statement = $this->db->prepare("INSERT INTO SanPham (TenSanPham, XuatXu, ThuongHieu, TheTich, NongDoCon, Gia, SoLuongConLai, AnhMinhHoa, TrangThai, MaLoaiSanPham, MoTa) VALUES (:tenSP, :xuatXu, :thuongHieu, :theTich, :nongDoCon, :gia, 1, :anhMinhHoa, 1, :maLoaiSanPham, :moTa)");

      // Bind các giá trị vào câu lệnh prepare với kiểu dữ liệu tương ứng
      $statement->bindParam(':tenSP', $tenSP, PDO::PARAM_STR);
      $statement->bindParam(':xuatXu', $xuatXu, PDO::PARAM_STR);
      $statement->bindParam(':thuongHieu', $thuongHieu, PDO::PARAM_STR);
      $statement->bindParam(':theTich', $theTich, PDO::PARAM_INT);
      $statement->bindParam(':nongDoCon', $nongDoCon, PDO::PARAM_INT);
      $statement->bindParam(':gia', $gia, PDO::PARAM_INT);
      $statement->bindParam(':anhMinhHoa', $anhMinhHoa, PDO::PARAM_STR);
      $statement->bindParam(':maLoaiSanPham', $maLoaiSanPham, PDO::PARAM_INT);
      $statement->bindParam(':moTa', $moTa, PDO::PARAM_STR);

      // Thực thi câu lệnh
      $statement->execute();

      return (object) [
        "status" => 200,
        "message" => "Thêm Sản Phẩm Thành công",
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => $e->getMessage(),
      ];
    } finally {
      // Đóng kết nối
      $this->db = null;
    }
  }


  public function updateProduct($maSP, $tenSP, $theTich, $gia, $nongDoCon, $xuatXu, $thuongHieu, $anhMinhHoa, $maLoaiSanPham, $moTa) {
    if (!isset($tenSP)) {
      return (object) [
        "status" => 400,
        "message" => "Tên sản phẩm không tồn tại",
      ];
    } elseif (!isset($maSP)) {
      return (object) [
        "status" => 400,
        "message" => "Mã Sản Phẩm không tồn tại",
      ];
    } elseif (!isset($theTich)) {
      return (object) [
        "status" => 400,
        "message" => "Thể tích không tồn tại",
      ];
    } elseif (!isset($gia)) {
      return (object) [
        "status" => 400,
        "message" => "Giá không tồn tại",
      ];
    } elseif (!isset($nongDoCon)) {
      return (object) [
        "status" => 400,
        "message" => "Nồng độ côn không tồn tại",
      ];
    } elseif (!isset($xuatXu)) {
      return (object) [
        "status" => 400,
        "message" => "Xuất xứ không tồn tại",
      ];
    } elseif (!isset($thuongHieu)) {
      return (object) [
        "status" => 400,
        "message" => "Thương hiệu không tồn tại",
      ];
    } elseif (!isset($anhMinhHoa)) {
      return (object) [
        "status" => 400,
        "message" => "Ảnh minh họa không tồn tại",
      ];
    } elseif (!isset($maLoaiSanPham)) {
      return (object) [
        "status" => 400,
        "message" => "Mã loại sản phẩm không tồn tại",
      ];
    } else {
      // Khởi tạo kết nối đến cơ sở dữ liệu
      $this->db = MysqlConfig::getConnection();
      try {
        $statement = $this->db->prepare("UPDATE SanPham SET TenSanPham = ?, XuatXu = ?, ThuongHieu = ?, TheTich = ?, NongDoCon = ?, Gia = ?, AnhMinhHoa = ?, MaLoaiSanPham = ?, MoTa = ? WHERE MaSanPham = ?");
        $statement->bindParam(1, $tenSP);
        $statement->bindParam(2, $xuatXu);
        $statement->bindParam(3, $thuongHieu);
        $statement->bindParam(4, $theTich);
        $statement->bindParam(5, $nongDoCon);
        $statement->bindParam(6, $gia);
        $statement->bindParam(7, $anhMinhHoa);
        $statement->bindParam(8, $maLoaiSanPham);
        $statement->bindParam(9, $moTa);
        $statement->bindParam(10, $maSP);
        $statement->execute();
        // $totalPages = null;
        return (object) [
          "status" => 200,
          "message" => "Cập Nhật Sản Phẩm Thành công",
        ];
      } catch (PDOException $e) {
        return (object) [
          "status" => 400,
          "message" => "Cập Nhật Sản Phẩm Không Thành công",
          "error" => $e->getMessage(),
        ];
      } finally {
        $this->db = null;
      }
    }
  }

  public function getAllProductsNoPaging() {
    $query = "SELECT * FROM `SanPham` WHERE Trangthai = 1";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $products = $statement->fetchAll(PDO::FETCH_ASSOC);
      return (object) [
        "status" => 200,
        "data" => $products,
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => $e->getMessage(),
      ];
    }
  }

  public function deleteProduct($maSP) {
    if (!isset($maSP)) {
      return (object) [
        "status" => 400,
        "message" => "Tên sản phẩm không tồn tại",
      ];
    } else {
      // Khởi tạo kết nối đến cơ sở dữ liệu
      $this->db = MysqlConfig::getConnection();
      try {
        $statement = $this->db->prepare("UPDATE SanPham SET TrangThai = 0 WHERE MaSP = $maSP");
        $statement->execute();
        // $totalPages = null;
        return (object) [
          "status" => 200,
          "message" => "Xóa Sản Phẩm Thành công",
        ];
      } catch (PDOException $e) {
        return (object) [
          "status" => 400,
          "message" => "Xóa Sản Phẩm Không Thành công",
        ];
      } finally {
        $this->db = null;
      }
    }
  }

  public function updateQuantityProduct($maSP, $quantity) {
    if (!isset($maSP)) {
      return (object) [
        "status" => 400,
        "message" => "Mã Sản Phẩm không tồn tại",
      ];
    } elseif (!isset($quantity)) {
      return (object) [
        "status" => 400,
        "message" => "Số lượng sản phẩm không tồn tại",
      ];
    } else {
      // Khởi tạo kết nối đến cơ sở dữ liệu
      $this->db = MysqlConfig::getConnection();
      try {
        // Check if quantity is zero, update TrangThai accordingly
        // $trangThai = ($quantity == 0) ? 0 : 1;

        $statement = $this->db->prepare("UPDATE SanPham SET SoLuongConLai = '$quantity' WHERE MaSanPham = $maSP");
        $statement->execute();
        // $totalPages = null;
        return (object) [
          "status" => 200,
          "message" => "Cập Nhật Sản Phẩm Thành công",
        ];
      } catch (PDOException $e) {
        return (object) [
          "status" => 400,
          "message" => "Cập Nhật Sản Phẩm Không Thành công",
        ];
      } finally {
        $this->db = null;
      }
    }
  }
  public function getProductBrand() {
    $query = "SELECT DISTINCT ThuongHieu FROM `SanPham`";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return ((object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result
      ]);
    } catch (PDOException $e) {
      return ((object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy thông tin thương hiệu",
      ]);
    } finally {
      $this->db = null;
    }
  }

  public function getProductOrigin() {
    $query = "SELECT DISTINCT XuatXu FROM `SanPham`";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return ((object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result
      ]);
    } catch (PDOException $e) {
      return ((object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy thông tin xuất xứ",
      ]);
    } finally {
      $this->db = null;
    }
  }

  public function getProductNongDoCon() {
    $query = "SELECT DISTINCT NongDoCon FROM `SanPham` ORDER BY NongDoCon ASC";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return ((object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result
      ]);
    } catch (PDOException $e) {
      return ((object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy thông tin về nồng độ cồn",
      ]);
    } finally {
      $this->db = null;
    }
  }

  public function getProductTheTich() {
    $query = "SELECT DISTINCT TheTich FROM `SanPham` ORDER BY TheTich ASC";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return ((object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result
      ]);
    } catch (PDOException $e) {
      return ((object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy thông tin về thể tích",
      ]);
    } finally {
      $this->db = null;
    }
  }

  public function getAllProductsNoStatus($page, $search, $theTich, $minGia, $maxGia, $minNongDoCon, $maxNongDoCon, $brand, $origin, $maLoaiSanPham, $sort) {
    // Khởi tạo câu truy vấn
    $query = "SELECT * FROM `SanPham` WHERE Trangthai IN (0, 1)";

    // Tạo mảng để lưu trữ các điều kiện WHERE
    $where_conditions = [];

    // Thêm điều kiện tìm kiếm
    if (isset($search)) {
      $where_conditions[] = "TenSanPham LIKE '%$search%'";
    }

    // Thêm điều kiện về thể tích
    if (isset($theTich)) {
      $where_conditions[] = "TheTich <= $theTich";
    }

    // Thêm điều kiện về giá
    if (isset($minGia) && isset($maxGia)) {
      $where_conditions[] = "Gia BETWEEN $minGia AND $maxGia";
    }

    // Thêm điều kiện về nồng độ chất còn lại
    if (isset($minNongDoCon) && isset($maxNongDoCon)) {
      $where_conditions[] = "NongDoCon BETWEEN $minNongDoCon AND $maxNongDoCon";
    }

    // Thêm điều kiện về thương hiệu
    if (isset($brand)) {
      $where_conditions[] = "ThuongHieu = '$brand'";
    }

    // Thêm điều kiện về xuất xứ
    if (isset($origin)) {
      $where_conditions[] = "XuatXu = '$origin'";
    }

    // Thêm điều kiện về mã loại sản phẩm
    if (isset($maLoaiSanPham)) {
      $where_conditions[] = "MaLoaiSanPham = '$maLoaiSanPham'";
    }

    // Kiểm tra xem có điều kiện WHERE nào không
    if (!empty($where_conditions)) {
      $query .= " AND " . implode(" AND ", $where_conditions);
    }

    // Thêm phần sắp xếp
    if ($sort === "price_asc") {
      $query .= " ORDER BY Gia ASC";
    } elseif ($sort === "price_desc") {
      $query .= " ORDER BY Gia DESC";
    } elseif ($sort === "name_asc") {
      $query .= " ORDER BY TenSanPham ASC";
    } elseif ($sort === "name_desc") {
      $query .= " ORDER BY TenSanPham DESC";
    } elseif ($sort === "id_asc") {
      $query .= " ORDER BY MaSanPham ASC";
    } elseif ($sort === "id_desc") {
      $query .= " ORDER BY MaSanPham DESC";
    } elseif ($sort === "nongDo_asc") {
      $query .= " ORDER BY NongDoCon ASC";
    } elseif ($sort === "nongDo_desc") {
      $query .= " ORDER BY NongDoCon DESC";
    } elseif ($sort === "theTich_asc") {
      $query .= " ORDER BY TheTich ASC";
    } elseif ($sort === "theTich_desc") {
      $query .= " ORDER BY TheTich DESC";
    } elseif ($sort === "soLuongConLai_ASC") {
      $query .= " ORDER BY SoLuongConLai ASC";
    } elseif ($sort === "soLuongConLai_DESC") {
      $query .= " ORDER BY SoLuongConLai DESC";
    } elseif ($sort === "trangThai_asc") {
      $query .= " ORDER BY Trangthai ASC";
    } elseif ($sort === "trangThai_desc") {
      $query .= " ORDER BY Trangthai DESC";
    }


    // Khởi tạo kết nối đến cơ sở dữ liệu
    $this->db = MysqlConfig::getConnection();
    try {
      // Thêm câu truy vấn để lấy tổng số sản phẩm từ câu truy vấn chính
      $count_query = "SELECT COUNT(*) FROM ($query) AS total_items";
      $statement_total_items = $this->db->prepare($count_query);
      $statement_total_items->execute();
      $total_items = $statement_total_items->fetchColumn();

      // Tính tổng số trang dựa trên số lượng sản phẩm và số sản phẩm mỗi trang
      $items_per_page = 6; // Số sản phẩm trên mỗi trang
      $total_pages = ceil($total_items / $items_per_page);

      // Xác định trang hiện tại và vị trí bắt đầu
      $current_page = isset($page) ? $page : 1;
      $start_from = ($current_page - 1) * $items_per_page;

      // Thêm phần giới hạn số lượng và vị trí bắt đầu vào câu truy vấn
      $query .= " LIMIT $start_from,$items_per_page";

      // Thực hiện truy vấn chính và trả về kết quả
      $statement = $this->db->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      // Trả về kết quả
      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
        "totalPages" => $total_pages,
        "SQL" => $query
      ];
    } catch (PDOException $e) {
      // Trả về thông báo lỗi nếu có lỗi xảy ra
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy sản phẩm",
        "SQL" => $query,
      ];
    } finally {
      // Đóng kết nối với cơ sở dữ liệu
      $this->db = null;
    }
  }


  public function updateTrangThai($maSanPham) {
    $query = "UPDATE SanPham SET TrangThai = CASE WHEN TrangThai = 1 THEN 0 ELSE 1 END WHERE MaSanPham = :maSanPham";
    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare($query);
      $statement->bindParam(':maSanPham', $maSanPham, PDO::PARAM_INT);
      $statement->execute();
      return (object) [
        "status" => 200,
        "message" => "success",
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "error",
        "error_code" => $e->getCode(), // Thêm mã lỗi vào đối tượng trả về
        "error_message" => $e->getMessage() // Thêm thông báo lỗi vào đối tượng trả về
      ];
    } finally {
      $this->db = null;
    }
  }
}
