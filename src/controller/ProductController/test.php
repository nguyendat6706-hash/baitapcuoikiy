<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
$modelLoaiSanPham = new LoaiSanPham();
$productModel = new ProductModel();
$dataGetLoaiSanPham = $modelLoaiSanPham->getAllTypeProduct(null, null)->data;
$result = $productModel->updateProduct(
    1, // maSanPham
    "Test Product", // tenSP
    100, // theTich
    50, // gia
    0.5, // nongDoCon
    "Vietnam", // xuatXu
    "Brand", // thuongHieu
    "path/to/image.jpg", // anhMinhHoa
    1 // maLoaiSanPham
);

// Hiển thị kết quả
var_dump($result);
