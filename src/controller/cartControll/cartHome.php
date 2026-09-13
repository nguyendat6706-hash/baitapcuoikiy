<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/CartModel.php";
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
require_once "$projectRoot/src/model/CartModel/DonHang.php";
require_once "$projectRoot/src/model/CartModel/TrangThaiDonHang.php";
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
      case 'showCart':
        $cart = new Cart();
        $maTaiKhoan = $_SESSION['MaTaiKhoan'];
        $data = $cart->getCart($maTaiKhoan);
        echo ($maTaiKhoan);
        require "$projectRoot/src/view/cart/cartView.php";
        break;
      case 'thanhtoan':
        $nguoiDungModel = new NguoiDungModel();
        $maTaiKhoan = $_SESSION['MaTaiKhoan'];
        $User = $nguoiDungModel->getNguoiDungByMaTK($maTaiKhoan);
        $cart = new Cart();
        $data = $cart->getCart($maTaiKhoan);
        $totalPrice = 0;
        foreach ($data->data as $cartData) {
          $totalPrice += $cartData['ThanhTien'];
        }
        $totalPrice_Shipping = $totalPrice;
        require_once "$projectRoot/src/view/cart/thanhtoan.php";
        break;
      case 'login':
        require_once "$projectRoot/src/view/home/login.php";
        break;
      default:
        // require '../../view/cart/cartView.php';
        exit();
    }
  } else {
    $modelCart = new Cart();
    $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    $dataCart = $modelCart->getCart($maTaiKhoan);

    if ($dataCart->status == 200) {
      header('Location: /UTH-PHP/src/controller/HomeController/HomeController.php');
      exit;
    }
  }
}
