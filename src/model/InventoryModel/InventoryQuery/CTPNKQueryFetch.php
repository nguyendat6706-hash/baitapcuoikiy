
<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/InventoryModel/ChiTietPhieuNhapKhoModel.php";
// Initialize the LoaiSanPham object
// Check if the request is an AJAX request
// Initialize the LoaiSanPham object
$inventoryModel = new ChiTietPhieuNhapKhoModel();

$result = $inventoryModel->getChiTietPhieuNhapKho($_GET['maPhieu']);

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($result);
?>