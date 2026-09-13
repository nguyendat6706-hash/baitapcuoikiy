<?php
ERROR_REPORTING(E_ALL);
ini_set('display_errors', 1);
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once $projectRoot . '/src/model/SupplierModels/NhaCungCapModel.php';
class UpdateSupplierController {
  public function display() {
    global $projectRoot;
    $supplierModel =  new NhaCungCap();
    if (!isset($_GET['maNhaCungCap'])) {
      echo "Không tìm thấy trang";
    } else {
      $maNhaCungCap = $_GET['maNhaCungCap'];
    }
    if ($supplierModel->getByMaNCC($maNhaCungCap)->status == 200) {
      $dataSupplier = $supplierModel->getByMaNCC($maNhaCungCap)->data;
    } else {
      echo "Không tìm thấy nhà cung cấp";
    }
    require_once $projectRoot . '/src/view/admin/supplier/updateSupplier.php';
  }

  public function requestUpdate() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      echo json_encode(array("status" => 405, "message" => "Phương thức không được hỗ trợ."));
      return;
    }
    if (!isset($_POST['TenNhaCungCap']) || !isset($_POST['SoDienThoai']) || !isset($_POST['Email']) || !isset($_POST['maNhaCungCap'])) {
      echo json_encode(array("status" => 400, "message" => "Thiếu thông tin."));
      return;
    }
    $modelSupplier = new NhaCungCap();
    $result = $modelSupplier->updateNhaCungCap($_POST['maNhaCungCap'], $_POST['TenNhaCungCap'], $_POST['Email'], $_POST['SoDienThoai']);
    echo json_encode(["status" => 200, "result" => $result]);
  }

  public function show() {
    if (!isset($_POST['action'])) {
      $this->display();
    } else {
      $action = $_POST['action'];
      if ($action = "updateSupplier") {
        $this->requestUpdate();
      }
    }
  }
}

$updateSupplierController = new UpdateSupplierController();
$updateSupplierController->show();
