<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/config/MysqlConfig.php";

class AnhSanPhamModel {

  private $db;

  /**
   * Thêm 1 ảnh cho 1 sản phẩm.
   * $duongDan: chuỗi ảnh (hiện tại project lưu base64, ví dụ "data:image/png;base64,...")
   */
  public function themAnh($maSanPham, $duongDan) {
    if (!isset($maSanPham) || !isset($duongDan) || empty($duongDan)) {
      return (object) [
        "status" => 400,
        "message" => "Thiếu Mã Sản Phẩm hoặc Đường Dẫn ảnh",
      ];
    }

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare(
        "INSERT INTO AnhSanPham (MaSanPham, DuongDan) VALUES (:maSanPham, :duongDan)"
      );
      $statement->bindParam(':maSanPham', $maSanPham, PDO::PARAM_INT);
      $statement->bindParam(':duongDan', $duongDan, PDO::PARAM_STR);
      $statement->execute();

      return (object) [
        "status" => 200,
        "message" => "Thêm ảnh thành công",
        "data" => [
          "MaAnh" => $this->db->lastInsertId(),
        ],
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể thêm ảnh",
        "error" => $e->getMessage(),
      ];
    } finally {
      $this->db = null;
    }
  }

  /**
   * Thêm nhiều ảnh cùng lúc cho 1 sản phẩm.
   * $mangDuongDan: mảng các chuỗi ảnh, ví dụ:
   *   ["data:image/png;base64,AAAA...", "data:image/png;base64,BBBB..."]
   * Dùng transaction: nếu 1 ảnh lỗi giữa chừng thì hủy (rollback) toàn bộ,
   * tránh tình trạng thêm nửa vời (VD: 5 ảnh chọn, chỉ lưu được 2 ảnh).
   */
  public function themNhieuAnh($maSanPham, $mangDuongDan) {
    if (!isset($maSanPham) || !isset($mangDuongDan) || !is_array($mangDuongDan) || count($mangDuongDan) === 0) {
      return (object) [
        "status" => 400,
        "message" => "Thiếu Mã Sản Phẩm hoặc danh sách ảnh rỗng",
      ];
    }

    $this->db = MysqlConfig::getConnection();
    $soAnhThemThanhCong = 0;
    $danhSachMaAnh = [];

    try {
      $this->db->beginTransaction();

      $statement = $this->db->prepare(
        "INSERT INTO AnhSanPham (MaSanPham, DuongDan) VALUES (:maSanPham, :duongDan)"
      );

      foreach ($mangDuongDan as $duongDan) {
        if (empty($duongDan)) {
          continue; // bỏ qua phần tử rỗng trong mảng
        }
        $statement->bindParam(':maSanPham', $maSanPham, PDO::PARAM_INT);
        $statement->bindParam(':duongDan', $duongDan, PDO::PARAM_STR);
        $statement->execute();

        $danhSachMaAnh[] = $this->db->lastInsertId();
        $soAnhThemThanhCong++;
      }

      $this->db->commit();

      return (object) [
        "status" => 200,
        "message" => "Thêm $soAnhThemThanhCong ảnh thành công",
        "data" => [
          "soLuongDaThem" => $soAnhThemThanhCong,
          "danhSachMaAnh" => $danhSachMaAnh,
        ],
      ];
    } catch (PDOException $e) {
      $this->db->rollBack();
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể thêm nhiều ảnh, đã hủy toàn bộ thao tác",
        "error" => $e->getMessage(),
      ];
    } finally {
      $this->db = null;
    }
  }

  /**
   * Lấy tất cả ảnh của 1 sản phẩm theo MaSanPham.
   * Dùng cho: trang chi tiết sản phẩm (gallery) và trang sửa sản phẩm (hiện ảnh cũ).
   */
  public function layAnhTheoSanPham($maSanPham) {
    if (!isset($maSanPham)) {
      return (object) [
        "status" => 400,
        "message" => "Thiếu Mã Sản Phẩm",
      ];
    }

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare(
        "SELECT * FROM AnhSanPham WHERE MaSanPham = :maSanPham"
      );
      $statement->bindParam(':maSanPham', $maSanPham, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      return (object) [
        "status" => 200,
        "message" => "Thành công",
        "data" => $result,
      ];
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể lấy ảnh sản phẩm",
        "error" => $e->getMessage(),
      ];
    } finally {
      $this->db = null;
    }
  }

  /**
   * Xóa 1 ảnh theo MaAnh.
   * Dùng khi sửa sản phẩm, người dùng bấm gỡ bớt 1 ảnh trong gallery.
   */
  public function xoaAnh($maAnh) {
    if (!isset($maAnh)) {
      return (object) [
        "status" => 400,
        "message" => "Thiếu Mã Ảnh",
      ];
    }

    $this->db = MysqlConfig::getConnection();
    try {
      $statement = $this->db->prepare(
        "DELETE FROM AnhSanPham WHERE MaAnh = :maAnh"
      );
      $statement->bindParam(':maAnh', $maAnh, PDO::PARAM_INT);
      $statement->execute();

      if ($statement->rowCount() > 0) {
        return (object) [
          "status" => 200,
          "message" => "Xóa ảnh thành công",
        ];
      } else {
        return (object) [
          "status" => 404,
          "message" => "Không tìm thấy ảnh để xóa",
        ];
      }
    } catch (PDOException $e) {
      return (object) [
        "status" => 400,
        "message" => "Lỗi không thể xóa ảnh",
        "error" => $e->getMessage(),
      ];
    } finally {
      $this->db = null;
    }
  }
}
