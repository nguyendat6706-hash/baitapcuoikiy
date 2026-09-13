<?php
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/CartModel.php";
class ManagerDetailDonHangController {
  public function display() {
    global $projectRoot;
    require_once "$projectRoot/src/model/CartModel/DonHang.php";
    $model = new DonHang();
    if (!isset($_GET['maDonHang'])) {
      echo "Not found value param maDonHang";
    } else {
      $maDonHang = $_GET['maDonHang'];
    }
    $data = $model->getDonHangByIdDonhang($maDonHang);
    $order_statuses = [];
    usort($data->data, function ($a, $b) {
      return strtotime($b['NgayCapNhat']) - strtotime($a['NgayCapNhat']);
    });

    require_once "$projectRoot/src/view/admin/managerDonHang/detail_donhang_manager.php";
  }

  public function request() {
  }

  public function show() {
    $this->display();
  }
}
$mangerDetailDonHangController = new ManagerDetailDonHangController();
$mangerDetailDonHangController->show();
