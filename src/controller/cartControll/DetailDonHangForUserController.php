<?php
ERROR_REPORTING(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/CartModel.php";
require_once "$projectRoot/src/model/CartModel/TrangThaiDonHang.php";
class DetailDonHangForUserController
{
  public function display()
  {
    global $projectRoot;
    require_once "$projectRoot/src/model/CartModel/DonHang.php";
    $modelDonHang = new DonHang();
    if (!isset($_GET['maDonHang'])) {
      echo "Not found value param maDonHang";
    } else {
      $maDonHang = $_GET['maDonHang'];
    }
    $dataDonHang = $modelDonHang->getDonHangByIdDonhang($maDonHang);
    $order_statuses = [];
    // usort($dataDonHang->data, function ($a, $b) {
    //   return strtotime($b['NgayCapNhat']) - strtotime($a['NgayCapNhat']);
    // });
    require_once "$projectRoot/src/view/detail_donhang/detail_donhang.php";
  }

  public function request()
  {
  }

  public function show()
  {
    $this->display();
  }
}
$detailDonHangForUserController = new DetailDonHangForUserController();
$detailDonHangForUserController->show();
