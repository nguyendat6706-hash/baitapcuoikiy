
<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/InventoryModel/ChiTietPhieuNhapKhoModel.php";
// Initialize the LoaiSanPham object
// Check if the request is an AJAX request
// Initialize the LoaiSanPham object
$inventoryModel = new ChiTietPhieuNhapKhoModel();

$result = $inventoryModel->createChiTietPhieuNhapKho($_POST['maPhieu'], $_POST['maSanPham'], $_POST['donGia'], $_POST['soLuong'], $_POST['thanhTien']);

// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($result);
?>