<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
class EditProductController {
  public $maSanPham;
  public function __construct() {
    if (isset($_GET['maSanPham'])) {
      $this->maSanPham = ($_GET['maSanPham']);
    }
  }
  public function display() {
    global $projectRoot;
    require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
    require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";
    $modelLoaiSanPham = new LoaiSanPham();
    $dataGetLoaiSanPham = $modelLoaiSanPham->getAllTypeProduct(null, null)->data;
    $modelProduct = new ProductModel();
    $dataProduct = $modelProduct->getProductById($this->maSanPham)->data; // Sử dụng $this->maSanPham

    // Lấy danh sách ảnh hiện có của sản phẩm (Ngày 3)
    require_once "$projectRoot/src/model/ProductModels/AnhSanPhamModel.php";
    $modelAnh = new AnhSanPhamModel();
    $ketQuaAnh = $modelAnh->layAnhTheoSanPham($this->maSanPham);
    $danhSachAnhCu = ($ketQuaAnh->status == 200) ? $ketQuaAnh->data : [];

    require "$projectRoot/src/view/admin/product/editProduct.php";
  }
  public function updateRequest() {
    $modelProduct = new ProductModel();
    // Kiểm tra xem yêu cầu có phải là Ajax không
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      // Kiểm tra phương thức yêu cầu có phải là POST không
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kiểm tra xem yêu cầu có phải là XMLHttpRequest không
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
          // Kiểm tra tất cả các tham số cần thiết có tồn tại không
          if (
            isset($_POST['TenSanPham']) && !empty($_POST['TenSanPham']) &&
            isset($_POST['Gia']) && is_numeric($_POST['Gia']) && $_POST['Gia'] > 0 &&
            isset($_POST['NongDo']) && is_numeric($_POST['NongDo']) && $_POST['NongDo'] > 0 &&
            isset($_POST['TheTich']) && is_numeric($_POST['TheTich']) && $_POST['TheTich'] > 0
            // Thêm các điều kiện kiểm tra số liệu cho các tham số còn lại tương tự ở đây
          ) {
            if ($_POST['NongDo'] > 100) {
              echo json_encode(array('status' => 400, 'message' => 'Nồng độ cồn không được lớn hơn 100'));
              exit();
            }
            // Lấy dữ liệu từ yêu cầu POST
            $maSanPham = $_POST['maSanPham'];
            $tenSP = $_POST['TenSanPham'];
            $gia = $_POST['Gia'];
            $nongDoCon = $_POST['NongDo'];
            $theTich = $_POST['TheTich'];
            $xuatXu = $_POST['XuatXu'];
            $thuongHieu = $_POST['ThuongHieu'];
            $maLoaiSanPham = $_POST['loaiSanPham'];

            // ==== Mô tả sản phẩm lấy từ CKEditor (Quang Huy) ====
            $moTa = isset($_POST['MoTa']) ? $_POST['MoTa'] : '';

            // ==== Xử lý ảnh mới thêm + ảnh bị đánh dấu xóa (Ngày 3 - Đạt) ====
            global $projectRoot;
            require_once "$projectRoot/src/model/ProductModels/AnhSanPhamModel.php";
            $modelAnh = new AnhSanPhamModel();

            $mangAnhMoi = isset($_POST['anhMoi']) ? $_POST['anhMoi'] : [];
            $mangMaAnhXoa = isset($_POST['maAnhXoa']) ? $_POST['maAnhXoa'] : [];

            // Xóa các ảnh bị đánh dấu xóa
            foreach ($mangMaAnhXoa as $maAnhCanXoa) {
              $modelAnh->xoaAnh($maAnhCanXoa);
            }

            // Thêm các ảnh mới (nếu có)
            if (is_array($mangAnhMoi) && count($mangAnhMoi) > 0) {
              $modelAnh->themNhieuAnh($maSanPham, $mangAnhMoi);
            }

            // Lấy lại danh sách ảnh sau cùng để xác định ảnh đại diện (AnhMinhHoa) mới
            $ketQuaAnhSauCung = $modelAnh->layAnhTheoSanPham($maSanPham);
            if ($ketQuaAnhSauCung->status == 200 && count($ketQuaAnhSauCung->data) > 0) {
              $anhMinhHoa = $ketQuaAnhSauCung->data[0]['DuongDan'];
            } else {
              // Không còn ảnh nào trong gallery -> giữ nguyên ảnh đại diện cũ, tránh mất ảnh hoàn toàn
              $sanPhamCu = $modelProduct->getProductById($maSanPham)->data;
              $anhMinhHoa = $sanPhamCu['AnhMinhHoa'];
            }

            // Thực hiện cập nhật sản phẩm
            $result = $modelProduct->updateProduct($maSanPham, $tenSP, $theTich, $gia, $nongDoCon, $xuatXu, $thuongHieu, $anhMinhHoa, $maLoaiSanPham, $moTa);

            // Kiểm tra kết quả và trả về phản hồi dưới dạng JSON
            if ($result->status == 200) {
              echo json_encode(array('status' => 200, 'message' => 'Cập nhật sản phẩm thành công'));
            } else {
              echo json_encode(array('status' => 500, 'message' => 'Cập nhật sản phẩm thất bại'));
            }
          } else {
            // Nếu thiếu tham số hoặc tham số không hợp lệ, trả về phản hồi lỗi
            echo json_encode(array('status' => 400, 'message' => 'Các giá trị nhập số bắt buộc phải lớn hơn 0'));
          }
        } else {
          // Nếu yêu cầu không phải là XMLHttpRequest, trả về phản hồi lỗi
          echo json_encode(array('status' => 403, 'message' => 'Yêu cầu không hợp lệ'));
        }
      }
    }
  }
  public function show() {
    if (isset($_POST['action']) && $_POST['action'] === 'updateProduct') {
      $this->updateRequest();
    } else {
      $this->display();
    }
  }
}
$editProductController = new EditProductController();
$editProductController->show();
