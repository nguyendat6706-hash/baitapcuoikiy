<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";

class ProductTypeAdjustController
{
    public function show()
    {
        $model = new LoaiSanPham();
        require $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP'."/src/view/admin/ProductType/ProductTypeAdjust/ProductTypeAdjust.php";
    }
}
$controller = new ProductTypeAdjustController();
$controller->show();
