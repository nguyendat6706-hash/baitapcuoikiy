<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/DonHang.php";


class OrderDetailsController
{
    public function show()
    {
        $model = new DonHang();
        // require "$projectRoot/src/view/admin/ProductType/ProductType.php";
        // require $projectRoot . "src/view/admin/ProductType/ProductType.php";
        require "../../view/admin/managerDonHang/detail_donhang_manager.php";


    }
}


$controller = new OrderDetailsController();
$controller->show();