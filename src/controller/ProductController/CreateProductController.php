<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
class CreateProductController {
  public function display() {
    global $projectRoot;
    require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";
    $modelLoaiSanPham = new LoaiSanPham();
    $dataGetLoaiSanPham = $modelLoaiSanPham->getAllTypeProduct(null, null)->data;
    require_once "$projectRoot/src/view/admin/product/createProduct.php";
  }
  public function createProduct() {
    $modelProduct = new ProductModel();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (
        isset($_POST['TenSanPham']) && !empty($_POST['TenSanPham']) &&
        isset($_POST['Gia']) && !empty($_POST['Gia']) && is_numeric($_POST['Gia']) && $_POST['Gia'] > 0 &&
        isset($_POST['NongDo']) && !empty($_POST['NongDo']) && is_numeric($_POST['NongDo']) && $_POST['NongDo'] > 0 &&
        isset($_POST['TheTich']) && !empty($_POST['TheTich']) && is_numeric($_POST['TheTich']) && $_POST['TheTich'] > 0
      ) {
        if ($_POST['NongDo'] > 100) {
          echo json_encode(array('status' => 400, 'message' => 'Nồng độ cồn không được lớn hơn 100'));
          exit();
        }

        // ==== Nhận mảng nhiều ảnh thay vì 1 ảnh đơn (Đạt) ====
        $mangAnh = isset($_POST['anhSanPham']) ? $_POST['anhSanPham'] : [];
        if (!is_array($mangAnh) || count($mangAnh) === 0) {
          echo json_encode(array('status' => 400, 'message' => 'Vui lòng chọn ít nhất 1 ảnh cho sản phẩm'));
          exit();
        }

        $tenSP = $_POST['TenSanPham'];
        $gia = $_POST['Gia'];
        $nongDoCon = $_POST['NongDo'];
        $theTich = $_POST['TheTich'];
        $xuatXu = $_POST['XuatXu'];
        $thuongHieu = $_POST['ThuongHieu'];
        $maLoaiSanPham = $_POST['loaiSanPham'];

        // ==== Mô tả sản phẩm lấy từ CKEditor (Quang Huy) ====
        $moTa = isset($_POST['MoTa']) ? $_POST['MoTa'] : '';

        // Ảnh đầu tiên trong mảng dùng làm ảnh đại diện (AnhMinhHoa)
        // để các trang danh sách/sản phẩm cũ vẫn hiển thị đúng, không cần sửa gì thêm
        $anhDaiDien = $mangAnh[0];

        $result = $modelProduct->createProduct($tenSP, $theTich, $gia, $nongDoCon, $xuatXu, $thuongHieu, $anhDaiDien, $maLoaiSanPham, $moTa);

        if ($result->status == 200) {
          // Lấy Mã Sản Phẩm vừa tạo để gắn toàn bộ ảnh vào bảng AnhSanPham
          $maSanPhamMoi = $result->data['MaSanPham'];
          global $projectRoot;
          require_once "$projectRoot/src/model/ProductModels/AnhSanPhamModel.php";
          $modelAnh = new AnhSanPhamModel();
          $ketQuaAnh = $modelAnh->themNhieuAnh($maSanPhamMoi, $mangAnh);

          if ($ketQuaAnh->status == 200) {
            echo json_encode(array('status' => 200, 'message' => 'Tạo sản phẩm thành công'));
          } else {
            // Sản phẩm đã tạo thành công, nhưng lưu ảnh phụ vào bảng AnhSanPham bị lỗi
            echo json_encode(array('status' => 200, 'message' => 'Tạo sản phẩm thành công, nhưng lưu ảnh phụ bị lỗi: ' . $ketQuaAnh->message));
          }
        } else {
          echo json_encode(array('status' => 500, 'message' => 'Tạo sản phẩm thất bại'));
        }
      } else {
        echo json_encode(array('status' => 400, 'message' => 'Các giá trị nhập số bắt buộc phải lớn hơn 0'));
      }
    }
  }
  public function show() {
    if (isset($_POST['action']) && $_POST['action'] === 'createProduct') {
      $this->createProduct();
    } else {
      $this->display();
    }
  }
}
$createProductController = new CreateProductController();
$createProductController->show();
