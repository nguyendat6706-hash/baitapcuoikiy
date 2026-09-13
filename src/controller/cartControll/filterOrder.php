<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/DonHang.php";

$maDonHang = $_POST['maDonHang'] ?? '';
$tuNgay = $_POST['tuNgay'] ?? '';
$denNgay = $_POST['denNgay'] ?? '';
$trangThai = $_POST['trangThai'] ?? '';

$donHangModel = new DonHang();
$data = $donHangModel->filterDonHang($maDonHang, $tuNgay, $denNgay, $trangThai);
// var_dump($data);

if ($data->status == 200) {
    if (count($data->data) > 0) {
        $trangThaiMap = array(
            'ChoDuyet' => 'Chờ duyệt',
            'DaDuyet' => 'Đã duyệt',
            'DangGiao' => 'Đang giao Hàng',
            'GiaoThanhCong' => 'Giao Hàng Thành Công',
            'Huy' => 'Đã Hủy',
        );

        foreach ($data->data as $record) {
            $tenTrangThai = $record['TenTrangThai'];
            if (array_key_exists($tenTrangThai, $trangThaiMap)) {
                $tenTrangThai = $trangThaiMap[$tenTrangThai];
            }

            echo '<tr>  
            <td class="Table_data_quyen_1 py-4">' . $record['MaDonHang'] . '</td>
            <td class="Table_data_quyen_1">' . $record['NgayDat'] . '</td>
            <td class="Table_data_quyen_1">' . number_format($record['TongGiaTri'], 0, ',', '.') . ' đ</td>
            <td class="Table_data_quyen_1">' . $record['MaKH'] . '</td>
            <td class="Table_data_quyen_1">' . $record['TenPhuongThuc'] . '</td>
            <td class="Table_data_quyen_1">' . $tenTrangThai . '</td>';
            if ($tenTrangThai == 'Chờ duyệt' || $tenTrangThai == 'Đã duyệt') {
                echo '<td class="Table_data_quyen_1"><a href="http://localhost/UTH-PHP/src/controller/cartControll/ManagerDetailDonHangController.php?maDonHang=' . $record['MaDonHang'] . '"> chi tiết</a> <button class="cancel_donhang"> hủy</button> </td>';
            } else {
                echo '<td class="Table_data_quyen_1"><a href="http://localhost/UTH-PHP/src/controller/cartControll/ManagerDetailDonHangController.php?maDonHang=' . $record['MaDonHang'] . '"> chi tiết</a> </td>';
            }
            // echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="7">Không có đơn hàng hợp lệ</td></tr>';
    }
} else {
    echo "Lỗi: " . $data->message;
}