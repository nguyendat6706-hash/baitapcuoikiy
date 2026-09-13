<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/AccountModels/QuyenModel.php";
require_once "$projectRoot/src/model/AccountModels/PhanQuyenModel.php";
require_once "$projectRoot/src/model/AccountModels/ChucNangModel.php";

// Khởi tạo controller và gọi phương thức show
class QuyenController
{
    public function ThemQuyen($TenQuyen, $DsChucNang)
    {
        $Quyen = new QuyenModel();
        $Quyen->createQuyen($TenQuyen, $DsChucNang);
        require_once "../view/RoleView.php";
    }
    public function XemTatCaQuyen()
    {
        $Quyen = new QuyenModel();
        $result = $Quyen->getAllQuyen(1, "")->data;
        require "../view/RoleView.php";
    }
    public function XemChiTietQuyen($id)
    { // Hàm này xem id quyền này có những chức năng nào
        $Quyen = new PhanQuyenModel();
        $results = $Quyen->getPhanQuyenByMaQuyen($id);
        $DanhSachMaChucNang = [];
        foreach ($results as $result) {
            array_push($MaChucNang, $results["MaChucNang"]);
        }
        $ChucNang = new ChucNangModel();
        $DsChucNang = $ChucNang->getChucNangByNhieuId($DanhSachMaChucNang);
        // goi view ChucNang và truyền them số $DanhSachMaChucNang để render ra
    }
    public function SuaDoiQuyen($idQuyen)
    {
    }
    public function XoaQuyen($idQuyen)
    {
    }
    public function Chon()
    {
    }

    public function test()
    {
    }
}
$controller = new QuyenController();
$controller->test();
