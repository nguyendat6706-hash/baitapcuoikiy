<?php
require_once ($projectRoot . "/src/model/AccountModels/ChucNangModel.php");
require_once ($projectRoot . "/src/model/AccountModels/PhanQuyenModel.php");
require_once ($projectRoot . "/src/model/AccountModels/QuyenModel.php");

class PhanQuyenController{
    public function XoaQuyen($MaQuyen){
            $PhanQuyen = new PhanQuyenModel();
            $PhanQuyen->deletePhanQuyen($MaQuyen);
            $Quyen = new QuyenModel();
            $Quyen->deleteQuyen($MaQuyen);

    }
    public function ThemQuyenVaTaoPhanQuyen($MaQuyen, $Danhsachchucnang)
    {
        $Quyen = new QuyenModel();
        $Quyen->createQuyen($MaQuyen, $Danhsachchucnang);
    }
    public function UpdateQuyenVaPhanQuyen($TenQuyen, $MaQuyen, $Danhsachchucnang)
    {
        $Quyen = new QuyenModel();
        $Quyen->updateQuyen($MaQuyen, $TenQuyen, $Danhsachchucnang);
    }
    public function displayChucNang($MaQuyen)
    {
        global $projectRoot;
        $Data = new PhanQuyenModel();
        $Quyen = new QuyenModel();
        $Res = $Data->getPhanQuyenByMaQuyen($MaQuyen);
        $Danhsachchucnang = [];
        foreach ($Res->data as $temp) {
            array_push($Danhsachchucnang, $temp["MaChucNang"]);
        }
        $Ten = $Quyen->getQuyenById($MaQuyen)->data["TenQuyen"];
        $IDQuyen = $MaQuyen;
        // print_r($IDQuyen);
        require_once "$projectRoot/src/view/DetailRoleReload.php";
        // print_r($Danhsachchucnang);
        // print_r($Ten);   

    }
    public static function kiemtraArray($Danhsachchucnang, $Ma)
    {
        if (in_array($Ma, $Danhsachchucnang)) {
            return true;
        } else {
            return false;
        }
    }
}
