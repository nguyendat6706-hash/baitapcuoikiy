<?php
require_once "/xampp/htdocs/UTH-PHP/src/model/ProductModels/SanPhamModel.php";
$modelProduct = new ProductModel();
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $data = $modelProduct->getProductById($id)->data;
} else {
  $data = null;
}
