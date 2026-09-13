<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';

// Sử dụng biến $projectRoot để yêu cầu các file cần thiết
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";
require_once "$projectRoot/src/model/AccountModels/TaiKhoanModel.php";


class NguoiDungController
{

    public function xoataikhoan($MaTaiKhoan)
    {
        $XoaNguoiDung = new NguoiDungModel();
        $XoaNguoiDung->deleteNguoiDung($MaTaiKhoan);
    }
    public function capNhatTaiKhoan($maTaiKhoan, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $email, $diaChi, $maQuyen, $DoiTuong)
    {
        $CapNhatNguoiDung = new NguoiDungModel();
        $CapNhatNguoiDung->updateNguoiDung($maTaiKhoan, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $email, $diaChi, $maQuyen, $DoiTuong);
    }
    public function displayChiTietTaiKhoan($maTaiKhoan)
    {
        $Hienthi = new NguoiDungModel();
        $Data = $Hienthi->getNguoiDungByMaTK($maTaiKhoan);
        $DataNguoiDung = $Data->data;
        require_once("../view/UpdateUserView.php");
    }
    public function createTaiKhoan($TenTaiKhoan, $MatKhau, $maQuyen, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $email, $diaChi, $DoiTuong)
    {
        $TaiKhoan = new TaiKhoanModel();
        $TaiKhoan->createTaiKhoan($TenTaiKhoan, $MatKhau, $maQuyen, $hoTen, $ngaySinh, $gioiTinh, $soDienThoai, $email, $diaChi, $DoiTuong);
    }
}
