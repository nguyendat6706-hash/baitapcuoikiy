
<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
// Initialize the LoaiSanPham object
// Check if the request is an AJAX request
// Initialize the LoaiSanPham object
$sanPhamModel = new ProductModel();


if (isset($_POST["action"])) {
  if ($_POST["action"] == "up") {
    $maSanPham = $_POST["maSanPham"];
    $soLuong = $_POST["soLuong"];

    $result = $sanPhamModel->updateTangSoLuong($maSanPham, $soLuong);
  }
} else {
  // Check if 'search' parameter exists
  if (isset($_GET['search'])) {
    // Call the getAllTypeProduct method to retrieve all product data with search parameter
    $result = $sanPhamModel->getAllProductsNoPagingForInventoryView($_GET['search']);
  } else {
    // Call the getAllTypeProduct method to retrieve all product data without search parameter
    $result = $sanPhamModel->getAllProductsNoPagingForInventoryView("");
  }
}




// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($result);

