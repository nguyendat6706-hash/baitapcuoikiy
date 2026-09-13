<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";
class InformationController {
  public function display() {
    global $projectRoot;
    $nguoiDungModel = new NguoiDungModel();
    $nguoiDung = $nguoiDungModel->getNguoiDungByMaTKClient($_SESSION['MaTaiKhoan']);
    require_once  "$projectRoot/src/view/thongtinuser/infomation.php";
  }

  public function reqestUpdateInformationUser() {
  }

  public function show() {
    if ($_SESSION['MaTaiKhoan']) {
      $this->display();
    }
  }
}

$informationController = new InformationController();
$informationController->show();
