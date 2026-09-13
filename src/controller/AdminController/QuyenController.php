<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/model/AccountModels/PhanQuyenModel.php";
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";
require_once "$projectRoot/src/model/AccountModels/ChucNangModel.php";


// class Controller {
//     public function show() {
//         // Tạo một đối tượng User
//         $object = new QuyenModel();
//         // Gọi view để hiển thị thông tin người dùng
//         require '..\view\View.php';
//     }
// }

// Khởi tạo controller và gọi phương thức show
class QuyenController {
  public function ThemQuyen($TenQuyen, $DsChucNang) {
    $Quyen = new QuyenModel();
    $Quyen->createQuyen($TenQuyen, $DsChucNang);
    require_once "../view/RoleView.php";
  }
  public function XemTatCaQuyen() {
    $Quyen = new QuyenModel();
    $result = $Quyen->getAllQuyen(1, "")->data;
    require "../view/RoleView.php";
  }
  public function XemChiTietQuyen($id) { // Hàm này xem id quyền này có những chức năng nào
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
  public function checkTenQuyen($tenQuyen) {
    $Quyen = new QuyenModel();
    $Kiemtra = $Quyen->KiemTraQuyen($tenQuyen);
    if ($Kiemtra->status == 200) {
      echo '<p id="thongbao" style="color:red;font-size:20px">Tên Quyền đã tồn tại</p>';
    }
    else if($Kiemtra->status == 404){
      echo '<p id="thongbao" style="color:green;font-size:20px">Tên Quyền có thể sử dụng</p>';
    }
    else if($Kiemtra->status == 500){
      echo '<p id="thongbao" style="color:red;font-size:20px">tên Quyền không thể rỗng</p>';
    }
  }
}
