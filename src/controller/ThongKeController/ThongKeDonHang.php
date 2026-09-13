<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ThongKeModel/ThongKeModel.php";


class ThongKeDonHangController
{
    public function show()
    {
        $model = new ThongKeModel();
        require "../../view/admin/ThongKe/ThongKeDonHang.php";

    }
}


$controller = new ThongKeDonHangController();
$controller->show();
