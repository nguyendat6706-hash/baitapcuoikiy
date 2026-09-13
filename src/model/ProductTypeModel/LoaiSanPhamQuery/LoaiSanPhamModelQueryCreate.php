<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";

// Initialize the LoaiSanPham object
$loaiSanPham = new LoaiSanPham();
// Call the getAllTypeProduct method to retrieve all product data with search parameter
$result = $loaiSanPham->createTypeProduct($_GET['tenloaisanpham']);
// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($result);
