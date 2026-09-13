<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";


class ProductTypeController
{
    public function show()
    {
        $model = new LoaiSanPham();
        // require "$projectRoot/src/view/admin/ProductType/ProductType.php";
        // require $projectRoot . "src/view/admin/ProductType/ProductType.php";
        require "../../view/admin/ProductType/ProductType.php";


    }
}


$controller = new ProductTypeController();
$controller->show();
