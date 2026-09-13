<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/model/SupplierModels/NhaCungCapModel.php";
require_once "$projectRoot/src/model/InventoryModel/PhieuNhapKhoForNhaCungCap.php";

class SupplierController
{
  public function display()
  {
    global $projectRoot;
    $modelSupplier = new NhaCungCap();
    $data = $modelSupplier->getAllNhaCungCap(null);
    require_once "$projectRoot/src/view/admin/supplier/supplierView.php";
  }

  private function checkFeatureExists($featureID)
  {
    return in_array($featureID, $_SESSION['chucNang']);
  }

  public function requestDeleteSupplier()
  {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      echo json_encode(array("status" => 405, "message" => "Phương thức không được hỗ trợ."));
      return;
    }
    if (!isset($_POST['maNhaCungCap'])) {
      echo json_encode(array("status" => 400, "message" => "Thiếu thông tin MaNhaCungCap."));
      return;
    }
    $maNhaCungCap = $_POST['maNhaCungCap'];
    $modelInventory = new PhieuNhapKhoForNCC();
    $modelSupplier = new NhaCungCap();

    $getDataPhieuNhapKho = $modelInventory->getPhieuNhapKhoByMaNCC($maNhaCungCap);
    if ($getDataPhieuNhapKho->status == 200 && !isset($getDataPhieuNhapKho->data)) {
      foreach ($getDataPhieuNhapKho->data as $item) {
        $resultUpdatePhieuNhapKho = $modelInventory->updatePhieuNhapKhoForNhaCungCap($item['MaPhieu']);
        if ($resultUpdatePhieuNhapKho->status !== 200) {
          echo json_encode(array("status" => 500, "message" => "Có lỗi xảy ra khi cập nhật phiếu nhập kho."));
          return;
        }
      }
    }


    $resultDeleteSupplier = $modelSupplier->deleteNhaCungCap($maNhaCungCap);
    if ($resultDeleteSupplier->status === 200) {
      echo json_encode(array("status" => 200, "message" => "Xóa nhà cung cấp thành công."));
    } else {
      echo json_encode(array(
        "status" => 500,
        "message" => "Có lỗi xảy ra khi xóa nhà cung cấp.",
        "error" => $resultDeleteSupplier->message
      ));
    }
  }

  public function requestFilter()
  {
    function getValueOrNull($param)
    {
      return isset($_POST[$param]) && $_POST[$param] !== '' ? $_POST[$param] : null;
    }

    // Get parameter values
    $search = getValueOrNull('search');

    // Lấy danh sách nhà cung cấp dựa trên các tham số lọc
    $modelSupplier = new NhaCungCap();
    $dataSupplier = $modelSupplier->getAllNhaCungCap($search);
    // Initialize variables
    $supplierHtml = '';

    if (!empty($dataSupplier->data)) {
      foreach ($dataSupplier->data as $item) {
        echo "<tr>
                <td>{$item['MaNCC']}</td>
                <td>{$item['TenNCC']}</td>
                <td>{$item['SoDienThoai']}</td>
                <td>{$item['Email']}</td>
                <td>";

        if ($this->checkFeatureExists(16)) {
          echo "<button type='button' class='btn btn-success text-light py-3 px-4 btn-update-supplier' data-maNhaCungCap={$item['MaNCC']}>Sửa</button>";
        }

        if ($this->checkFeatureExists(17)) {
          echo "<button type='button' class='btn btn-danger text-light py-3 px-4 btn-delete-supplier' data-maNhaCungCap={$item['MaNCC']}>Xóa</button>";
        }

        echo "</td></tr>";
      }
    } else {
      echo "<tr><td colspan='5'>Không có nhà cung cấp phù hợp.</td></tr>";
    }
  }

  public function show()
  {
    if (isset($_POST['action'])) {
      $action = $_POST['action'];
      switch ($action) {
        case "deleteSupplier":
          $this->requestDeleteSupplier();
          break;
        case "createSupplier":
          echo json_encode(array("status" => 200, "message" => "Thành công"));
          break;
        case "filter":
          $this->requestFilter();
          break;
      }
    } else {
      $this->display();
    }
  }
}

$supplierController = new SupplierController();
$supplierController->show();
