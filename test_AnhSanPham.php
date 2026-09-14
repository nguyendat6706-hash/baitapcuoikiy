<?php
/**
 * FILE TEST NHANH cho AnhSanPhamModel — dùng dữ liệu giả, KHÔNG nối vào form.
 *
 * Cách chạy:
 * 1. Copy file này vào thư mục gốc project, ngang hàng với index.php
 *    (C:\xampp\htdocs\UTH-PHP\test_AnhSanPham.php)
 * 2. Copy AnhSanPhamModel.php vào: C:\xampp\htdocs\UTH-PHP\src\model\ProductModels\
 * 3. Mở trình duyệt: http://localhost/UTH-PHP/test_AnhSanPham.php
 * 4. Đọc kết quả in ra — nếu tất cả các "status" đều là 200 là code chạy đúng.
 * 5. Test xong thì XÓA file này đi (không để lại trên server thật).
 */

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/model/ProductModels/AnhSanPhamModel.php";
require_once "$projectRoot/src/config/MysqlConfig.php";

echo "<pre>"; // để print_r xuống dòng đẹp khi xem trên trình duyệt

$model = new AnhSanPhamModel();

// ===== BƯỚC 0: Lấy tạm 1 sản phẩm có sẵn trong DB để test =====
// (bắt buộc phải có MaSanPham thật vì bảng AnhSanPham có khóa ngoại tới SanPham)
$db = MysqlConfig::getConnection();
$stmt = $db->query("SELECT MaSanPham, TenSanPham FROM SanPham LIMIT 1");
$sanPham = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sanPham) {
    die("Chưa có sản phẩm nào trong DB để test. Vào phpMyAdmin / trang quản lý tạo thử 1 sản phẩm trước đã nhé.");
}

$maSanPham = $sanPham['MaSanPham'];
echo "Đang test với sản phẩm: {$sanPham['TenSanPham']} (Mã: $maSanPham)\n\n";

// ===== BƯỚC 1: Test themAnh() - thêm 1 ảnh giả =====
echo "===== TEST themAnh() =====\n";
$ketQua1 = $model->themAnh($maSanPham, "fake_base64_anh_don_le_001");
print_r($ketQua1);
echo "\n";

// ===== BƯỚC 2: Test themNhieuAnh() - thêm 3 ảnh giả cùng lúc =====
echo "===== TEST themNhieuAnh() =====\n";
$mangAnhGia = [
    "fake_base64_anh_002",
    "fake_base64_anh_003",
    "fake_base64_anh_004",
];
$ketQua2 = $model->themNhieuAnh($maSanPham, $mangAnhGia);
print_r($ketQua2);
echo "\n";

// ===== BƯỚC 3: Test layAnhTheoSanPham() - lấy lại toàn bộ ảnh vừa thêm =====
echo "===== TEST layAnhTheoSanPham() =====\n";
$ketQua3 = $model->layAnhTheoSanPham($maSanPham);
print_r($ketQua3);
echo "\n";

// ===== BƯỚC 4: Test xoaAnh() - xóa thử ảnh đầu tiên trong danh sách vừa lấy =====
echo "===== TEST xoaAnh() =====\n";
if ($ketQua3->status === 200 && count($ketQua3->data) > 0) {
    $maAnhCanXoa = $ketQua3->data[0]['MaAnh'];
    echo "Đang xóa thử ảnh có Mã Ảnh = $maAnhCanXoa\n";
    $ketQua4 = $model->xoaAnh($maAnhCanXoa);
    print_r($ketQua4);

    echo "\n--- Kiểm tra lại danh sách ảnh sau khi xóa ---\n";
    $ketQuaSauXoa = $model->layAnhTheoSanPham($maSanPham);
    print_r($ketQuaSauXoa);
} else {
    echo "Không có ảnh nào để test xóa.\n";
}

echo "</pre>";
