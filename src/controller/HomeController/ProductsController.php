<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
require_once "$projectRoot/src/model/CartModel/CartModel.php";
require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";

class HomeController {
  public function display() {
    global $projectRoot;
    $modelProduct = new ProductModel();
    $loaiSanPhamModel = new LoaiSanPham();
    $dataLoaiSanPham = $loaiSanPhamModel->getAllTypeProduct(null, null)->data;
    $dataSanPham = $modelProduct->getAllProductsNoPaging();
    $dataBranch = $modelProduct->getProductBrand();
    $dataOrigin = $modelProduct->getProductOrigin();
    // Gọi view
    require_once "$projectRoot/src/view/home/products.php";
  }

  public function handleRequestSwitchPage() {
    if (isset($_POST['maSanPham'])) {
      // Lấy mã sản phẩm từ dữ liệu gửi lên
      $maSanPham = $_POST['maSanPham'];

      // Đây là nơi bạn xử lý mã sản phẩm và trả về thông tin sản phẩm tương ứng
      // Ví dụ:
      $response = [
        'status' => 200,
        'productId' => $maSanPham
      ];

      // Chuyển định dạng dữ liệu thành JSON và trả về cho client
      echo json_encode($response);
    } else {
      // Nếu không có mã sản phẩm được gửi lên, trả về mã lỗi
      $response = [
        'status' => 400,
        'message' => 'Lỗi: Không có mã sản phẩm được gửi lên.'
      ];

      echo json_encode($response);
    }
  }

  public function show() {
    if (isset($_POST['action'])) {
      $action = $_POST['action'];
      switch ($action) {
        case "detailProduct":
          $this->handleRequestSwitchPage();
          break;
        case "filter":
          $this->handleRequestFilter();
          break;
      }
    } else {
      $this->display();
    }
  }
}

$homeController = new HomeController();
$homeController->show();
