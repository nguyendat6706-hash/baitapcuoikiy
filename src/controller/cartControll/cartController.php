<?php
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/CartModel.php";
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
require_once "$projectRoot/src/model/CartModel/DonHang.php";
require_once "$projectRoot/src/model/CartModel/TrangThaiDonHang.php";
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $action = $_POST['action'];

  if ($action == 'increase' || $action == 'decrease' || $action == "inputSoLuong") {
    $cart = new Cart();
    if (!isset($_SESSION['MaTaiKhoan'])) {
      echo json_encode(array("status" => 400, "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng"));
      return;
    } else {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    }

    $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    $data = $cart->getCart($maTaiKhoan);


    if (!isset($_POST['productId'])) {
      echo json_encode(array("status" => 400, "message" => "Missing product ID"));
      return;
    }

    $product_id = $_POST['productId'];
    foreach ($data->data as $key => $product) {
      if ($product_id == $product['MaSanPham']) {
        if ($action == 'increase' || $action == 'decrease') {
          $newQuantity = $action == 'increase' ? $product['SoLuong'] + 1 : $product['SoLuong'] - 1;
          $newQuantity = max(1, $newQuantity);

          $allproduct = new ProductModel();
          $dataProduct = $allproduct->getAllProducts(null, null, null, null, null, null, null, null, null, null, null);

          foreach ($dataProduct->data as $dataProduct) {
            if ($dataProduct['MaSanPham'] == $product_id)
              if ($action == 'increase') {
                if ($newQuantity > $dataProduct['SoLuongConLai']) {
                  echo json_encode(['error' => 'Số lượng vượt quá số lượng còn lại của sản phẩm']);
                  exit;
                }
              }
            if ($action == 'decrease') {
              $newQuantity = $product['SoLuong'] - 1;
            }
          }
        }
        if ($action == 'inputSoLuong') {
          $newQuantity = $_POST['newQuantity'];
          // echo json_encode(array("newQuantity" => $newQuantity));
        }


        $valueTotalPrice = $product['DonGia'] * $newQuantity;
        $maTaiKhoan = $_SESSION['MaTaiKhoan'];
        $result = $cart->updateCart($maTaiKhoan, $product_id, $product['DonGia'], $newQuantity, $valueTotalPrice);
        $data->data[$key]['SoLuong'] = $newQuantity;
        $data->data[$key]['ThanhTien'] = $valueTotalPrice;


        $totalPrice = 0;
        foreach ($data->data as $cartProduct) {
          if (array_key_exists('ThanhTien', $cartProduct)) {
            $totalPrice += $cartProduct['ThanhTien'];
          }
        }
        break;
      }
    }
    echo json_encode([
      'newQuantity' => $newQuantity,
      'totalPrice' => number_format($totalPrice, 0, ',', '.') . ' đ',
      'valueTotalPrice' => number_format($valueTotalPrice, 0, ',', '.') . ' đ'
    ]);
  } else if ($action == 'deleteCart') {
    $cart = new Cart();
    if (!isset($_SESSION['MaTaiKhoan'])) {
      echo json_encode(array("status" => 400, "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng"));
      return;
    } else {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    }

    // Check if productId is set in the POST data
    if (!isset($_POST['productId'])) {
      echo json_encode(array("status" => 400, "message" => "Missing product ID"));
      return;
    }
    $product_id = $_POST['productId'];
    $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    $result = $cart->deleteCart($maTaiKhoan, $product_id);
    if ($result->status == 200) {
      $data = $cart->getCart($maTaiKhoan);
      $totalPrice = 0;
      $totalCart = 0;
      foreach ($data->data as $cartProduct) {
        if (isset($cartProduct['ThanhTien'])) {
          $totalPrice += $cartProduct['ThanhTien'];
          $totalCart++;
        }
      }
      echo json_encode(array(
        'priceTotal' => number_format($totalPrice, 0, ',', '.') . ' đ',
        'quantityCart' => $totalCart
      ));
    } else {
      echo json_encode(array(
        'error' => 'Error deleting cart item'
      ));
    }
  } else if ($action == 'addToCart') {
    if (!isset($_SESSION['MaTaiKhoan'])) {
      echo json_encode(array("status" => 400, "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng"));
      return;
    } else {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    }


    $product_id = (int)$_POST['productId'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $modelProduct = new ProductModel();
    $data = $modelProduct->getAllProductsNoPaging();
    $productExists = false;
    $cartModel = new Cart();
    $cartItems = $cartModel->getCart($maTaiKhoan);

    foreach ($data->data as $product) {
      if ($product['MaSanPham'] === $product_id) {
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
            $newQuantity = $item['SoLuong'] + $quantity;
            $maTaiKhoan = $_SESSION['MaTaiKhoan'];
            $result = $cartModel->updateCart($maTaiKhoan, $product_id, $product_price, $newQuantity, $product_price * $newQuantity);
            $productExists = true;
            break;
          }
        }


        if (!$productExists) {
          $maTaiKhoan = $_SESSION['MaTaiKhoan'];
          $result1 = $cartModel->createCart($maTaiKhoan, $product_id, $product_price, $quantity, $product_price * $quantity);
        }
        $maTaiKhoan = $_SESSION['MaTaiKhoan'];
        $cartItems = $cartModel->getCart($maTaiKhoan);
        $quantity_cart = count($cartItems->data);
      }
    }


    echo json_encode(array("quantity" => $quantity_cart));
    /* echo json_encode(array("result" => $result, "cartItems" => $cartItems, "quantity" => $quantity_cart, "result1" => $result1, "maTaiKhoan" => $maTaiKhoan, "product_id" => $product_id, "quantity" => $quantity, "product_price" => $product_price, "data" => $data->status)); */
    return;
  } else if ($action == 'thanhtoan') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : '';
    $shippingMethod = isset($_POST['shippingMethod']) ? $_POST['shippingMethod'] : '';
    // $totalPrice = isset($_POST['total_price']) ? $_POST['total_price'] : null;

    $cartModel = new Cart();
    if (!isset($_SESSION['MaTaiKhoan'])) {
      echo "login";
    } else {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    }

    $nguoiDungModel = new NguoiDungModel();
    $getDataNguoiDung = $nguoiDungModel->getNguoiDungByMaTKClient($maTaiKhoan)->data;
    $nguoiDungModel->updatenguoidungforuser($maTaiKhoan, $username, null, null, $phoneNumber, $getDataNguoiDung['Email'], $address);

    $cartItems = $cartModel->getCart($maTaiKhoan);
    $totalPrice = 0;
    foreach ($cartItems->data as $cartItem) {
      $totalPrice += $cartItem['ThanhTien'];
    }

    $donHang = new DonHang();
    $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    $result = $donHang->createDonHang($totalPrice, $maTaiKhoan, $address, $paymentMethod, $shippingMethod);
    $ttdh = new TrangThaiDonHang();
    $madonhang = $donHang->getIDDonHangMoiChen();
    $createTTDH = $ttdh->createTrangThaiDonHang('ChoDuyet', $madonhang, null);
    $cartModel = new Cart();
    $allProduct = new ProductModel();


    foreach ($cartItems->data as $cartItem) {
      $masp = $cartItem['MaSanPham'];
      $dongia = $cartItem['DonGia'];
      $soluong = $cartItem['SoLuong'];
      $thanhtien = $cartItem['ThanhTien'];
      $ctDonHang = $donHang->create_Ct_DonHang($madonhang, $masp, $dongia, $soluong, $thanhtien);
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
      $cart = $cartModel->deleteCart($maTaiKhoan, $masp);
    }

    // $donhang_1 = $donHang->getDonHangByIdDonhang($madonhang);
    // foreach ($donhang_1->data as $dataDonHang) {

    //   $newQuantity = $dataDonHang['SoLuongConLai'] - $dataDonHang['SoLuong'];
    //   $result1 = $allProduct->updateQuantityProduct($dataDonHang['MaSanPham'], $newQuantity);
    // }

    echo json_encode([
      'success' => true,
      "maTaiKhoan" => $maTaiKhoan,
      "createTTDH" => $createTTDH,
    ]);
    exit;
  } else  if ($action == 'huyDonHang') {
    $maDonHang = isset($_POST['maDonHang']) ? $_POST['maDonHang'] : '';
    $TrangThai = isset($_POST['TrangThai']) ? $_POST['TrangThai'] : '';

    $trangthai = new TrangThaiDonHang();
    $allProduct = new ProductModel();
    $allDonHang = new DonHang();
    $donhang = $allDonHang->getDonHangByIdDonhang($maDonHang);
    $newQuantity = 0;
    if ($donhang->status == 200 && !empty($donhang->data)) {
      foreach ($donhang->data as $dataDonHang) {
        $maSanPham = $dataDonHang['MaSanPham'];
        $soLuong = $dataDonHang['SoLuong'];
        $soLuongConLai = $dataDonHang['SoLuongConLai'];
        if ($TrangThai === 'Đã duyệt') {
          $newQuantity = $soLuong + $soLuongConLai;
          $result1 = $allProduct->updateQuantityProduct($maSanPham, $newQuantity);
        }
        if (!isset($_SESSION['MaTaiKhoan'])) {
          echo json_encode(array("status" => 400, "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng"));
        } else {
          $maTaiKhoan = $_SESSION['MaTaiKhoan'];
        }
        $result2 = $trangthai->updateTrangThaiDonHang('Huy', $maDonHang, $maTaiKhoan);
      }

      echo json_encode(array("status" => 200, "message" => "Đơn hàng đã được hủy thành công."));
    } else {
      echo json_encode(array("status" => 400, "message" => "Không tìm thấy đơn hàng."));
    }
  } else if ($action == 'received') {
    if (!isset($_POST['maDonHang'])) {
      echo json_encode(array("status" => 400, "message" => "Missing order ID"));
    }
    $maDonHang = isset($_POST['maDonHang']) ? $_POST['maDonHang'] : '';
    $trangthai = new TrangThaiDonHang();
    if (isset($_SESSION['MaTaiKhoan'])) {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    } else {
      echo json_encode(array("status" => 400, "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng"));
      exit();
    }
    $result = $trangthai->createTrangThaiDonHang('GiaoThanhCong', $maDonHang, $maTaiKhoan);
  } else if ($action == 'update_status') {
    $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : '';
    $clickedIndex = isset($_POST['clickedIndex']) ? $_POST['clickedIndex'] : '';
    $trangthai = new TrangThaiDonHang();

    if (isset($_SESSION['MaTaiKhoan'])) {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    } else {
      echo "Not Athorzation";
    }

    if ($_SESSION['role'] === 2 || $_SESSION['role'] === 1) {
      if ($clickedIndex == 1) {
        $donHangModel = new DonHang();
        $allProduct = new ProductModel();
        $donhangInfo = $donHangModel->getDonHangByIdDonhang($orderId);
        foreach ($donhangInfo->data as $dataDonHang) {
          $newQuantity = $dataDonHang['SoLuongConLai'] - $dataDonHang['SoLuong'];
          if ($newQuantity < 0) {
            $result = false;
            break;
          }
          $result = $trangthai->createTrangThaiDonHang('DaDuyet', $orderId, $maTaiKhoan);
          $result1 = $allProduct->updateQuantityProduct($dataDonHang['MaSanPham'], $newQuantity);
        }
      } elseif ($clickedIndex == 2) {
        $result = $trangthai->createTrangThaiDonHang('DangGiao', $orderId, $maTaiKhoan);
      } elseif ($clickedIndex == 4) {
        $result = $trangthai->createTrangThaiDonHang('Huy', $orderId, $maTaiKhoan);
      } elseif ($clickedIndex == 3) {
        $result = $trangthai->createTrangThaiDonHang('GiaoThanhCong', $orderId, $maTaiKhoan);
      }
    } elseif ($_SESSION['role'] === 3) {
      if ($clickedIndex == 3) {
        $result = $trangthai->createTrangThaiDonHang('GiaoThanhCong', $orderId, $maTaiKhoan);
      }
    }


    echo json_encode(array("result" => $result));
  }
  /* if ($action == 'filter_orders') { */
  /*   $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : ''; */
  /*   $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : ''; */
  /*   $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : ''; */
  /**/
  /**/
  /**/
  /*   $trangthai = new TrangThaiDonHang(); */
  /*   $allDonHang = new DonHang(); */
  /**/
  /*   if (isset($orderId) && $fromDate === null && $toDate === null) { */
  /*     $result = $allDonHang->getDonHangByIdDonhang($orderId); */
  /*   } */
  /* } else { */
  /*   header('HTTP/1.1 400 Bad Request'); */
  /*   echo 'Bad Request'; */
  /* } */
}
