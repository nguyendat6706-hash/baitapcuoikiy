<?php
ERROR_REPORTING(E_ALL);
ini_set('display_errors', 1);
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once $projectRoot . '/src/model/SupplierModels/NhaCungCapModel.php';
$supplierModel = new NhaCungCap();
$data = $supplierModel->updateNhaCungCap(1, 'Nha cung cap 1', '0123456789', 'huybang2017@gmail.com');
var_dump($data);
