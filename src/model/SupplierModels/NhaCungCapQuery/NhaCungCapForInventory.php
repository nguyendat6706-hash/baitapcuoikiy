
<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/SupplierModels/NhaCungCapModel.php";

$nhaCungCapModel = new NhaCungCap();


    // Call the getAllTypeProduct method to retrieve all product data without search parameter
    $result = $nhaCungCapModel->getAllNhaCungCapNoPaging();


// Output the result as JSON
header('Content-Type: application/json');
echo json_encode($result);