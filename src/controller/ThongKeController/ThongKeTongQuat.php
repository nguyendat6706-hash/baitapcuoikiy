<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ThongKeModel/ThongKeModel.php";


class ThongKeTongQuatController
{
    public function show()
    {
        $model = new ThongKeModel();
        require "../../view/admin/ThongKe/ThongKeTongQuat.php";

    }
}


$controller = new ThongKeTongQuatController();
$controller->show();
