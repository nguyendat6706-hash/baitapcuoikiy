<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
$modelProduct = new ProductModel();
$data = $modelProduct->getAllProducts(null, null, null, null, null, null, null, null, null, null);

// Kiểm tra xem session đã được thiết lập hay chưa
if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['role'])) {
    echo "MaTaiKhoan: " . $_SESSION['MaTaiKhoan'] . "<br>";
    echo "Username: " . $_SESSION['username'] . "<br>";
    echo "Password: " . $_SESSION['password'] . "<br>";
    echo "Role: " . $_SESSION['role'] . "<br>";

    // Kiểm tra và hiển thị nội dung của mảng $_SESSION['chucNang']
    if (isset($_SESSION['chucNang'])) {
        echo "Danh sách các quyền:\n";
        var_dump($_SESSION['chucNang']);
    } else {
        echo "Mảng chứa danh sách các quyền chưa được thiết lập.";
    }
} else {
    echo "Session chưa được thiết lập.";
}
