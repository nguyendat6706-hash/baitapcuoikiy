SELECT * FROM `Quyen` ;

SELECT * FROM `TaiKhoan` JOIN `Quyen` ON `TaiKhoan`.`MaQuyen` = `Quyen`.`MaQuyen` ;


SELECT * FROM `TaiKhoan` JOIN `NguoiDung` ON `TaiKhoan`.`MaTK` = `NguoiDung`.`MaTK` ;


SELECT COUNT(*) FROM `Quyen`;

UPDATE `Quyen` SET `TenQuyen` = ":3" WHERE `MaQuyen` = 12;

INSERT INTO `TaiKhoan` (`TenDangNhap`, `MatKhau`, `MaQuyen`) VALUES
('Thug24', '0204', 1);

SELECT * FROM TaiKhoan;


SELECT * FROM `TaiKhoan` tk JOIN Quyen q ON tk.MaQuyen = q.MaQuyen;

DELETE FROM TaiKhoan WHERE MaTaiKhoan = 13;

SELECT * FROM TaiKhoan JOIN NguoiDung ON TaiKhoan.MaTaiKhoan = NguoiDung.MaTaiKhoan;

SELECT * FROM NguoiDung;

SELECT * FROM PHANQUYEN;

SELECT * FROM Quyen;

UPDATE TaiKhoan SET `MaQuyen` = 13 WHERE MaTaiKhoan = 8;



-- Thống kê đơn hàng
-- THống kê doanh thu
-- Thống kê chi tiêu

