<?php
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/CartModel.php";
class ManagerDonHangController
{
  public function display()
  {
    global $projectRoot;
    require_once "$projectRoot/src/model/CartModel/DonHang.php";
    $model = new DonHang();
    if (!isset($_SESSION['MaTaiKhoan'])) {
      echo "<script>alert('Bạn cần đăng nhập để xem đơn hàng')</script>";
      exit;
    } else {
      $maTaiKhoan = $_SESSION['MaTaiKhoan'];
    }

    $data = $model->getAllDonHang();
    require_once "$projectRoot/src/view/admin/managerDonHang/managerDon.php";
  }

  public function request()
  {
  }

  public function show()
  {
    $this->display();
  }
}
$mangerDonHangController = new ManagerDonHangController();
$mangerDonHangController->show();