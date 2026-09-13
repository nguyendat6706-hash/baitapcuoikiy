<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/DonHang.php";


class OrderController
{
    public function show()
    {
        $model = new DonHang();
        // require "$projectRoot/src/view/admin/ProductType/ProductType.php";
        // require $projectRoot . "src/view/admin/ProductType/ProductType.php";
        require "../../view/admin/managerDonHang/managerDon.php";


    }
}


$controller = new OrderController();
$controller->show();