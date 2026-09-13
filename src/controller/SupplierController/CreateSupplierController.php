<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/model/SupplierModels/NhaCungCapModel.php";
class CreateSupplierController
{
  public function display()
  {
    global $projectRoot;
    require_once "$projectRoot/src/view/admin/supplier/createSupplier.php";
  }

  public function createSupplier()
  {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      echo json_encode(array("status" => 405, "message" => "Phương thức không được hỗ trợ."));
      return;
    }
    if (!isset($_POST['TenNhaCungCap']) || !isset($_POST['SoDienThoai']) || !isset($_POST['Email'])) {
      echo json_encode(array("status" => 400, "message" => "Thiếu thông tin."));
      return;
    }
    $modelSupplier = new NhaCungCap();
    $checkSupplierExists = $modelSupplier->getAllNhaCungCap($_POST['TenNhaCungCap'])->data;
    if (!empty($checkSupplierExists)) {
      echo json_encode(array("status" => 400, "message" => "Nhà cung cấp đã tồn tại."));
      return;
    }

    $result = $modelSupplier->createNhaCungCap($_POST['TenNhaCungCap'], $_POST['Email'], $_POST['SoDienThoai']);
    echo json_encode($result);
  }

  public function show()
  {
    if (isset($_POST['action'])) {
      $action = $_POST['action'];
      switch ($action) {
        case "createSupplier":
          $this->createSupplier();
          break;
      }
    } else {
      $this->display();
    }
  }
}

$createSupplierController = new CreateSupplierController();
$createSupplierController->show();
