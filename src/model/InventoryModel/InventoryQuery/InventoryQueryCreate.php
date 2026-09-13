
<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/InventoryModel/InventoryModel.php";
// Initialize the LoaiSanPham object
// Check if the request is an AJAX request
// Initialize the LoaiSanPham object
$inventoryModel = new InventoryModel();

$result = $inventoryModel->createPhieuNhapKho($_POST['tongGiaTri'] , $_POST['maNCC'], $_POST['maQuanLy']);

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($result);
?>

