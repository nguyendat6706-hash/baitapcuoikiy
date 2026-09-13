<?php 
    require_once "../ThongKeModel.php";

    $thongKe = new ThongKeModel();

    if (isset($_GET['action'])){

        if ($_GET['action'] == "thongKePhieuNhapKho"){

            $result = $thongKe->thongKePhieuNhapKho();
        }


        if ($_GET['action'] == "thongKeTaiKhoan"){

            $result = $thongKe->thongKeTaiKhoan();
        }


        if ($_GET['action'] == "thongKeSanPham"){

            $result = $thongKe->thongKeSanPham();
        }


        if ($_GET['action'] == "thongKeNhaCungCap"){

            $result = $thongKe->thongKeNhaCungCap();
        }


        if ($_GET['action'] == "thongKeDonHang"){
            $from = $_GET['from'];
            $to = $_GET['to'];

            $result = $thongKe->thongKeDonHang($from, $to);
        }


        if ($_GET['action'] == "thongKeDoanhThu"){
            $from = $_GET['from'];
            $to = $_GET['to'];
            $maLoaiSanPham = $_GET['maLoaiSanPham'] == 0 ? null: $_GET['maLoaiSanPham'];

            $result = $thongKe->thongKeDoanhThu($from, $to,  $maLoaiSanPham );
        }


        if ($_GET['action'] == "thongKeChiTieu"){
            $from = $_GET['from'];
            $to = $_GET['to'];
            $maLoaiSanPham = $_GET['maLoaiSanPham'] == 0 ? null: $_GET['maLoaiSanPham'];

            $result = $thongKe->thongKeChiTieu($from, $to, $maLoaiSanPham);
        }

        
        if ($_GET['action'] == "thongKeSanPhamBanChay"){
            $from = $_GET['from'];
            $to = $_GET['to'];
            $maLoaiSanPham = $_GET['maLoaiSanPham'] == 0 ? null: $_GET['maLoaiSanPham'];

            
            $result = $thongKe->thongKeSanPhamBanChay($from, $to, $maLoaiSanPham);
        }

    }

    echo json_encode($result);
?>