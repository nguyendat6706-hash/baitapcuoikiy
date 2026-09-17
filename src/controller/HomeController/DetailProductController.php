<?php
ERROR_REPORTING(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/CartModel.php";
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
require_once "$projectRoot/src/model/CartModel/DonHang.php";
require_once "$projectRoot/src/model/CartModel/TrangThaiDonHang.php";
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";

class DetailProductController {
  public function display() {
    global $projectRoot;
    $dataProduct = $this->requestUrl();

    // Lấy danh sách ảnh phụ của sản phẩm để hiển thị gallery (Ngày 3)
    require_once "$projectRoot/src/model/ProductModels/AnhSanPhamModel.php";
    $modelAnh = new AnhSanPhamModel();
    $ketQuaAnh = $modelAnh->layAnhTheoSanPham($dataProduct['MaSanPham']);
    $danhSachAnhPhu = ($ketQuaAnh->status == 200) ? $ketQuaAnh->data : [];

    // require_once "$projectRoot/src/view/include/header.php";
    require_once "$projectRoot/src/view/home/detailProduct.php";
    // require_once "$projectRoot/src/view/include/footer.php";
  }
  public function requestUrl() {
    global $projectRoot;
    if (isset($_GET['maSanPham'])) {
      require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
      $productId = $_GET['maSanPham'];
      $modelProduct = new ProductModel();
      $dataProduct = $modelProduct->getProductById($productId)->data;
      return $dataProduct;
    }
  }
  public function addToCart() {
    if (!isset($_SESSION['MaTaiKhoan'])) {
      echo json_encode(array("status" => 400, "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng"));
      return;
    } else {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    }

    if (!isset($_POST['quantity'])) {
      echo json_encode(array("status" => 400, "message" => "Số lượng sản phẩm không được để trống"));
    } else {
      $quantity = $_POST['quantity'];
    }

    if (!isset($_POST['productId'])) {
      echo json_encode(array("status" => 400, "message" => "Mã sản phẩm không được để trống"));
    } else {
      $product_id = $_POST['productId'];
    }

    $modelProduct = new ProductModel();
    $data = $modelProduct->getAllProducts(null, null, null, null, null, null, null, null, null, null, null);
    $productExists = false;
    $cartModel = new Cart();
    $cartItems = $cartModel->getCart($maTaiKhoan);

    foreach ($data->data as $product) {
      if ($product['MaSanPham'] == $product_id) {
        if ($product['SoLuongConLai'] === 0) {
          echo json_encode(['status' => 401, 'message' => 'Sản phẩm đã hết hàng']);
          exit;
        }

        $product_price = $product['Gia'];
        foreach ($cartItems->data as $item) {

          if ($item['MaSanPham'] == $product_id) {
            if ($product['SoLuongConLai'] < $item['SoLuong'] + 1) {
              echo json_encode(['status' => 402, 'message' => 'Số lượng vượt quá số lượng còn lại của sản phẩm']);
              exit;
            }
            $newQuantity = $item['SoLuong'] + 1;
            $maTaiKhoan = $_SESSION['MaTaiKhoan'];
            $result = $cartModel->updateCart($maTaiKhoan, $product_id, $product_price, $newQuantity, $product_price * $newQuantity);
            $productExists = true;
            break;
          }
        }

        if (!$productExists) {
          $maTaiKhoan = $_SESSION['MaTaiKhoan'];
          $result = $cartModel->createCart($maTaiKhoan, $product_id, $product_price, $quantity, $product_price * $quantity);
        }
        $maTaiKhoan = $_SESSION['MaTaiKhoan'];
        $cartItems = $cartModel->getCart($maTaiKhoan);
        $quantity_cart = count($cartItems->data);
      }
    }


    echo json_encode(array("quantity" => $quantity_cart));
    return;
  }
  public function show() {
    if (!isset($_POST['action'])) {
      $this->display();
    } else {
      $action = $_POST['action'];
      switch ($action) {
        case 'addToCart':
          $this->addToCart();
          $this->display();
          break;
      }
    }
  }
}
$detailProductController = new DetailProductController();
$detailProductController->show();
