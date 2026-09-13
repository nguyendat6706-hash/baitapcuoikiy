-- Tạo cơ sở dữ liệu mới (nếu chưa tồn tại)
DROP DATABASE IF EXISTS `UTH_PHP_Database`;
CREATE DATABASE IF NOT EXISTS `UTH_PHP_Database`;

-- Sử dụng cơ sở dữ liệu mới hoặc có sẵn
USE `UTH_PHP_Database`;



/* _____________________________________________________________________ CÁC BẢNG LIÊN QUAN TỚI TÀI KHOẢN _________________________________________________________*/


/* ____________________ PHÂN QUYỀN ___________________ */
DROP TABLE IF EXISTS `ChucNang`;
CREATE TABLE IF NOT EXISTS `ChucNang` (
	  `MaChucNang` 		INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `TenChucNang`      NVARCHAR(255) 	NOT NULL  UNIQUE
);

DROP TABLE IF EXISTS `Quyen`;
CREATE TABLE IF NOT EXISTS `Quyen` (
	`MaQuyen` 		INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `TenQuyen`      NVARCHAR(255) 	NOT NULL UNIQUE
);

DROP TABLE IF EXISTS `PhanQuyen`;
CREATE TABLE IF NOT EXISTS `PhanQuyen` (
	`MaQuyen` 			INT UNSIGNED,
    `MaChucNang` 		INT UNSIGNED,
	PRIMARY KEY (`MaQuyen`, `MaChucNang`),
	FOREIGN KEY (`MaQuyen`) REFERENCES `Quyen`(`MaQuyen`),
	FOREIGN KEY (`MaChucNang`) REFERENCES `ChucNang`(`MaChucNang`)
);

/*______________________________ TÀI KHOẢN VÀ NGƯỜI DÙNG___________________________ */


DROP TABLE IF EXISTS `TaiKhoan`;
CREATE TABLE IF NOT EXISTS `TaiKhoan` (
    `MaTaiKhoan`        INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `TenDangNhap`       NVARCHAR(255)           NOT NULL    UNIQUE,
    `MatKhau`           NVARCHAR(255)           NOT NULL,
    `TrangThai`         BOOLEAN                 NOT NULL    DEFAULT true,
    `NgayTao`           DATETIME                NOT NULL    DEFAULT NOW(),
    `IsAllow`			INT UNSIGNED ,
    `MaQuyen`           INT UNSIGNED,
    FOREIGN KEY (`MaQuyen`) REFERENCES `Quyen`(`MaQuyen`)
);


DROP TABLE IF EXISTS `NguoiDung`;
CREATE TABLE IF NOT EXISTS `NguoiDung` (
    `MaNguoiDung`  		INT UNSIGNED 	PRIMARY KEY 					AUTO_INCREMENT,
    `HoTen` 			NVARCHAR(255) 											,
    `NgaySinh`			DATE 													,
    `GioiTinh`  		ENUM('Male', 'Female')  								,
    `SoDienThoai` 		NVARCHAR(20) 											,
    `Email` 			NVARCHAR(255) 	UNIQUE									NOT NULL,
    `DiaChi` 			NVARCHAR(255)											,
	  `DoiTuong` 			ENUM("KhachHang", "QuanLy", "NhanVienKyThuat", "NhanVienKinhDoanh", "CEO")  NOT NULL,
    `MaTaiKhoan` 		INT UNSIGNED                                             ,
	FOREIGN KEY (`MaTaiKhoan`) REFERENCES `TaiKhoan`(`MaTaiKhoan`)
);

/* _____________________________________________________________________ CÁC BẢNG LIÊN QUAN TỚI SẢN PHẨM _________________________________________________________*/


DROP TABLE IF EXISTS `LoaiSanPham`;
CREATE TABLE IF NOT EXISTS `LoaiSanPham` (
    `MaLoaiSanPham` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `TenLoaiSanPham` NVARCHAR(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS `SanPham`;
CREATE TABLE IF NOT EXISTS `SanPham` (
	`MaSanPham` 	INT  UNSIGNED 			PRIMARY KEY AUTO_INCREMENT,
    `TenSanPham` 	NVARCHAR(255) 			NOT NULL 	UNIQUE,
    `XuatXu` 		NVARCHAR(255) 			NOT NULL,
	`ThuongHieu` 	NVARCHAR(255) 			NOT NULL,
    `TheTich` 		SMALLINT UNSIGNED 		NOT NULL,
    `NongDoCon` 	FLOAT UNSIGNED			NOT NULL,
    `Gia` 			INT UNSIGNED 			NOT NULL,
    `SoLuongConLai` INT UNSIGNED 			NOT NULL 	DEFAULT 0,
    `AnhMinhHoa` 	LONGTEXT,
	`TrangThai` 	BOOLEAN NOT NULL,
	
    `MaLoaiSanPham` INT UNSIGNED 			NOT NULL,
    FOREIGN KEY (`MaLoaiSanPHam`) REFERENCES `LoaiSanPham`(`MaLoaiSanPham`)
);

/* _____________________________________________________________________ CÁC BẢNG LIÊN QUAN TỚI NGHIEP VU NHAP KHO _________________________________________________________*/
DROP TABLE IF EXISTS `NhaCungCap`;
CREATE TABLE IF NOT EXISTS  `NhaCungCap` (
    `MaNCC` 		INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `TenNCC` 		NVARCHAR(255) 		NOT NULL UNIQUE,
    `SoDienThoai` 	NVARCHAR(50) 		NOT NULL,
    `Email` 		NVARCHAR(255) 		NOT NULL
);

DROP TABLE IF EXISTS `PhieuNhapKho`;
CREATE TABLE IF NOT EXISTS  `PhieuNhapKho` (
    `MaPhieu` 			INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `NgayNhapKho` 		DATETIME 				NOT NULL DEFAULT NOW(),
    `TongGiaTri` 		INT UNSIGNED 			NOT NULL,
    `MaNCC`				INT UNSIGNED,
    `MaQuanLy` 			INT UNSIGNED,
    FOREIGN KEY (`MaNCC`) 		REFERENCES `NhaCungCap`(`MaNCC`),
	FOREIGN KEY (`MaQuanLy`) 	REFERENCES `TaiKhoan`(`MaTaiKhoan`)
);

DROP TABLE IF EXISTS `CTPNK`;
CREATE TABLE IF NOT EXISTS  `CTPNK` (
    `DonGiaNhap` 	INT UNSIGNED 	NOT NULL,
	`SoLuong` 		INT UNSIGNED  	NOT NULL,
	`ThanhTien` 	INT UNSIGNED 	NOT NULL,
    `MaPhieu` 		INT UNSIGNED,
    `MaSanPham` 			INT UNSIGNED,
    FOREIGN KEY (`MaPhieu`) 	REFERENCES `PhieuNhapKho`(`MaPhieu`),
	FOREIGN KEY (`MaSanPham`) 		REFERENCES `SanPham`(`MaSanPham`),
    PRIMARY KEY (`MaPhieu`, `MaSanPham`)
);


/* _____________________________________________________________________ CÁC BẢNG LIÊN QUAN TỚI NGHIEP VU MUA HÀNG _________________________________________________________*/

DROP TABLE IF EXISTS `GioHang`;
CREATE TABLE IF NOT EXISTS  `GioHang` (
    `DonGia` 			INT UNSIGNED NOT NULL,
	`SoLuong` 			INT UNSIGNED NOT NULL,
    `ThanhTien` 		INT UNSIGNED NOT NULL,
    `MaTaiKhoan` 		INT UNSIGNED,
    `MaSanPham` 		INT UNSIGNED,
    FOREIGN KEY (`MaTaiKhoan`) REFERENCES `TaiKhoan`(`MaTaiKhoan`),
	FOREIGN KEY (`MaSanPham`) REFERENCES `SanPham`(`MaSanPham`),
    PRIMARY KEY (`MaTaiKhoan`, `MaSanPham`)
);

DROP TABLE IF EXISTS `PhuongThucThanhToan`;
CREATE TABLE IF NOT EXISTS `PhuongThucThanhToan`(
	`MaPhuongThuc`  			INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `TenPhuongThuc` 			NVARCHAR(255) 	UNIQUE
);

DROP TABLE IF EXISTS `DichVuVanChuyen`;
CREATE TABLE IF NOT EXISTS `DichVuVanChuyen`(
	`MaDichVu`  			INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `TenDichVu` 			NVARCHAR(255) 	UNIQUE
);

DROP TABLE IF EXISTS `DonHang`;
CREATE TABLE IF NOT EXISTS `DonHang`(
	`MaDonHang`  			INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `NgayDat` 				DATETIME NOT NULL, 
    `TongGiaTri` 			INT UNSIGNED NOT NULL,
    `MaKH` 					INT UNSIGNED NOT NULL,
    `DiaChiGiaoHang`		NVARCHAR(255) NOT NULL,
    `MaPhuongThuc` 			INT UNSIGNED,
    `MaDichVu`   			INT UNSIGNED,
	FOREIGN KEY (`MaKH`) 			REFERENCES `TaiKhoan`(`MaTaiKhoan`),
    FOREIGN KEY (`MaPhuongThuc`) 	REFERENCES `PhuongThucThanhToan`(`MaPhuongThuc`),
	FOREIGN KEY (`MaDichVu` ) 		REFERENCES `DichVuVanChuyen`(`MaDichVu`)

);

DROP TABLE IF EXISTS `TrangThaiDonHang`;
CREATE TABLE IF NOT EXISTS `TrangThaiDonHang`(
    `TrangThai` 	        ENUM ("ChoDuyet", "DaDuyet", "Huy", "DangGiao" , "GiaoThanhCong") NOT NULL,
    `NgayCapNhat` 	        DATETIME DEFAULT NOW(), -- Ngày này sẽ được cập nhật dựa theo sự thay đổi của TrangThai
	`MaDonHang`  		    INT UNSIGNED,
    `MaNguoiCapNhat`	    INT UNSIGNED,
	FOREIGN KEY (`MaDonHang`) REFERENCES `DonHang`(`MaDonHang`),
    PRIMARY KEY(`MaDonHang`, `TrangThai`)
);


DROP TABLE IF EXISTS `CTDH`;
CREATE TABLE IF NOT EXISTS  `CTDH` (
	`SoLuong`           		INT UNSIGNED    NOT NULL,
    `ThanhTien`         		INT UNSIGNED    NOT NULL,
    `DonGia`            		INT UNSIGNED    NOT NULL,
    `MaDonHang`              	INT UNSIGNED,
    `MaSanPham`              	INT UNSIGNED,
	FOREIGN KEY (`MaDonHang`) REFERENCES `DonHang`(`MaDonHang`),
	FOREIGN KEY (`MaSanPham`) REFERENCES `SanPham`(`MaSanPham`),
    PRIMARY KEY (`MaDonHang`, `MaSanPham`)
);

-- Dữ liệu mẫu cho bảng ChucNang
INSERT INTO `ChucNang` (`MaChucNang`, `TenChucNang`) VALUES

-- Các chức năng mặc định
(1, 'Chức năng mua hàng'), -- CHức năng này bao gồm xem các món hàng được bán, giỏ hàng, mua hàng, quản lý đơn hàng cá nhân.

-- 4 chức năng CRUD Tài khoản của Admin
(2, 'Xem danh sách tài khoản'),
(3, 'Tạo tài khoản'),
(4, 'Cập nhật tài khoản'),
(5, 'Khóa mở tài khoản'),


-- 4 chức năng CRUD Sản phẩm của Manager
(6, 'Xem danh sách sản phẩm'),
(7, 'Tạo sản phẩm'),
(8, 'Cập nhật sản phẩm'),
(9, 'Khóa mở sản phẩm'),

-- 4 chức năng CRUD Loại Sản phẩm của Manager
(10, 'Xem danh sách loại sản phẩm'),
(11, 'Tạo loại sản phẩm'),
(12, 'Cập nhật loại sản phẩm'),
(13, 'Xóa loại sản phẩm'),

-- 4 chức năng CRUD Nhà cung cấp của Manager
(14, 'Xem danh sách nhà cung cấp'),
(15, 'Tạo  nhà cung cấp'),
(16, 'Cập nhật  nhà cung cấp'),
(17, 'Xóa  nhà cung cấp'),

-- 2 chức năng Quản lý Phiếu nhập kho của Manager
(18, 'Xem danh sách phiếu nhập kho'),
(19, 'Tạo  phiếu nhập kho'),
(20, 'Cập nhật nhập kho'),


-- 2 chức năng QL Đơn hàng của Manager
(21, 'Xem danh sách đơn hàng'),
(22, 'Cập nhật đơn hàng'),

-- 4 chức năng QL Người Dùng của Manager
(23, 'Xem danh sách người dùng'),
(24, 'Tạo người dùng hệ thống'),
(25, 'Cập nhật người dùng'),
(26, 'Xóa Người Dùng Hệ Thống'),

(27, 'Xem danh sách quyền'),
(28, 'Thêm quyền'),
(29, 'Cập nhật quyền'),
(30, 'xóa quyền'),


-- Thống kê
(31, 'Thống kê tổng quát'),
(32, 'Thống kê đơn hàng');




-- Dữ liệu mẫu cho bảng Quyen
INSERT INTO `Quyen` (`TenQuyen`) VALUES
('Admin'),
('User');

-- Dữ liệu mẫu cho bảng PhanQuyen
INSERT INTO `PhanQuyen` (`MaQuyen`, `MaChucNang`) VALUES

-- Quyền của Admin = All quyền
(1, 1), 
(1, 2), 
(1, 3), 
(1, 4), 
(1, 5), 
(1, 6), 
(1, 7), 
(1, 8), 
(1, 9), 
(1, 10), 
(1, 11), 
(1, 12), 
(1, 13), 
(1, 14), 
(1, 15), 
(1, 16), 
(1, 17), 
(1, 18), 
(1, 19), 

(1, 20), 
(1, 21), 
(1, 22), 
(1, 23), 
(1, 24), 
(1, 25), 
(1, 26), 

(1, 27), 
(1, 28), 
(1, 29), 
(1, 30), 

(1, 31), 
(1, 32), 
-- Quyền của khách hàng: Các quyền mặc định
(2, 1);



-- Dữ liệu mẫu cho bảng TaiKhoan
INSERT INTO `TaiKhoan` (`TenDangNhap`, `MatKhau`, `MaQuyen`, `IsAllow`) VALUES
						('THug24'	, '123456', 1, 0), -- Admin
						('TanTai'	, '123456', 1,  0), -- Manager
						('HuuNghia'	, '123456', 2,  0), -- Manager
						('DucHuy'	, '123456', 2,  0), -- Manager
						('AnhDai'	, '123456', 2,  0), -- Manager
						('customer0', '123456', 2,  0), -- Customer
						('customer1', '123456', 2,  0), -- Customer
						('customer2', '123456', 2,  0), -- Customer
						('customer3', '123456', 2,  0), -- Customer
						('customer4', '123456', 2,  0), -- Customer
						('customer5', '123456', 2,  0); -- Customer

-- Dữ liệu mẫu cho bảng NguoiDung
INSERT INTO `NguoiDung` (`HoTen`, 			`NgaySinh`, `GioiTinh`, `SoDienThoai`, `Email`, `DiaChi`, `DoiTuong`, `MaTaiKhoan`) VALUES
						('Ngô Tuấn Hưng', 	'1990-01-01', 'Male', '0123456789', 'hungnt.020404@example.com', '123 Admin Street', 'NhanVienKyThuat', 1),
						('Lai Tấn Tài', 	'1980-02-02', 'Male', '0987654321', 'tantailai@example.com', '456 Manager Street', 'NhanVienKinhDoanh', 2),
						('Trương Hữu Nghĩa','1980-02-02', 'Male', '0987654321', 'huunghiatruong@example.com', '456 Manager Street', 'NhanVienKinhDoanh', 3),
						('Nguyễn Đức Huy', 	'1980-02-02', 'Male', '0987654321', 'duchuynguyen@example.com', '456 Manager Street', 'NhanVienKinhDoanh', 4),
						('Đỗ Anh Đài', 		'1980-02-02', 'Male', '0987654321', 'anhdaido@example.com', '456 Manager Street', 'NhanVienKinhDoanh', 5),

						('Customer0', 		'2000-04-04', 'Female', '0987654321', 'customer0@example.com', '101 Customer Street', 'KhachHang', 6),
						('Customer1', 		'2000-04-04', 'Female', '0987654321', 'customer1@example.com', '101 Customer Street', 'KhachHang', 7),
						('Customer2', 		'2000-04-04', 'Female', '0987654321', 'customer2@example.com', '101 Customer Street', 'KhachHang', 8),
						('Customer3', 		'2000-04-04', 'Female', '0987654321', 'customer3@example.com', '101 Customer Street', 'KhachHang', 9),
						('Customer4', 		'2000-04-04', 'Female', '0987654321', 'customer4@example.com', '101 Customer Street', 'KhachHang', 10),
						('Customer5', 		'2000-04-04', 'Female', '0987654321', 'customer5@example.com', '101 Customer Street', 'KhachHang', 11);

-- Dữ liệu mẫu cho bảng LoaiSanPham
INSERT INTO `LoaiSanPham` (`TenLoaiSanPham`) VALUES
							('Các loại rượu khác'),
							('Rượu Vodka'),
							('Rượu Tequila'),
							('Rượu Whiskey');

-- Dữ liệu mẫu cho bảng SanPham
INSERT INTO `SanPham`	(`MaSanPham`, `TenSanPham`, 															    `XuatXu`,       `TheTich`, `ThuongHieu` ,                           `NongDoCon`,    `Gia`,      `SoLuongConLai`, `MaLoaiSanPham` , `TrangThai`, `AnhMinhHoa`)
VALUES					(1,      'HaKu Vodka',                                                          'Nhật Bản',     700,        "Suntory"	,	                        40.82,          850000,     10,                 2,                true       , "https://sanhruou.com/media/3865/catalog/Haku-Vodka.jpg"),
                        (2,      'HaNoi VodKa',                                                         'Việt Nam',     750,        "Hanoi Wine", 	                        38 ,            120000,     10,                 2,                true       , "https://www.lottemart.vn/media/catalog/product/cache/0x0/8/9/8934591001196.jpg.webp")   ,                     
                        (3,      'Beluga Noble',                                                        'Nga',          1000,       "Beluga"			,	                40,             1100000,    10,                 2,                true       , "https://www.phanphoiruoungoai.net/wp-content/uploads/2018/10/ruou-vodka-beluga-noble-1-L.jpg"),
                        (4,      'Grey Groose',                                                         'Pháp',         750,        "Sidney Frank Importing Company",       45,             650000,     10,                 2,                true        , "https://sanhruou.com/media/14052/catalog/Grey-Goose-Vodka.jpg"),  
                        (5,      'Beluga Allure',                                                       'Nga',          700,        "Beluga"			,                   41,             850000,     10,                 2,                true        , "https://www.phanphoiruoungoai.net/wp-content/uploads/2017/11/ruou-vodka-beluga-allure.jpg"),
                        (6,      'King Robert',                                                         'Nga',          1000,       "Beluga"			,                   45,             250000,     10,                 2,                true        , "https://dukaan.b-cdn.net/1000x1000/webp/projecteagle/images/d44a8cd0-4b9d-43df-b68d-955f54f1d9da.jpg"),
                        (7,      'Smirnoff Red Vodka',                                                  'Nga',          1000,       "Beluga"			,                   37.5,           850000,     10,                 2,                true        , "https://sanhruou.com/media/4209/catalog/smirnoff-red.jpg"),
                        (8,      'Stolichnaya Vodka',                                                   'Nga',   	    950,        "Stoli"					,               40,             390000,     10,                 2,                true        , "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBGdXYteva6DWS9rHIGUcOgpl7XyidWxIK6aBbZ5RzVA&s"),
                        (9,      'Vodka Danzka',                                                        'Đan Mạch',     750,        "Danzka",			                    40,             300000,     10,                 2,                true        , "https://sanhruou.com/media/489/catalog/ruou-vodka-danzka-nhom-1-lit.jpg"),
                        (10,     "Glen'S Platinum",                                                     'Anh',          650,        " Glen's Platinum Scotch Whisky",       37.5,           600000,     10,                 2,                true        , "https://vintagewine.vn/wp-content/uploads/2023/04/Ruou-Glens-Vodka-Platinium.jpg"),   
                        
                        (11,     'Tequila Clase las AZUL 25 ANIVERSARIO',                               'Mexico',       1000,       "Tequila Clase Azul", 	                40,             8000000,    10,                 3,                false       , "https://robbreport.mx/wp-content/uploads/2022/05/clase-azul-mexico-tequi-25-aniversario4.jpg"),  
                        (12,     'Tequila Rooster Rojo Blanco',                                         'Mexico',       800,        "Tequila Clase Azul",	                40,             1000000,    10,                 3,                true        , "https://th.bing.com/th/id/OIP.WReGiTNayPqTrteWJzJM1gHaHa?rs=1&pid=ImgDetMain"),
                        (13,     'Tequila Rooster Rojo Anejo',                                          'Mexico',       750,        "Tequila Clase Azul",	                37.5,           1900000,    10,                 3,                true        , "https://th.bing.com/th/id/OIP.A0uDPTC6dXQPrj2MD7RByAHaHa?rs=1&pid=ImgDetMain"),
                        (14,     'Tequila Sierra Silver',                                               'Mexico',       1000,       "Tequila Clase Azul",	                40,             1240000,    10,                 3,                true        , "https://th.bing.com/th/id/OIP.45m44Z3IpN4VD3dZODCY0QHaHa?rs=1&pid=ImgDetMain"),
                        (15,     'Tequila Don Julio Anejo',                                             'Mexico',       600,      	"Don Julio Gonzalez",  	                45,             920000,     10,                 3,                true        , "https://th.bing.com/th/id/R.4cb6a6bef0be740e8bb4cc96b8c740c2?rik=jjBIzaiGLwF0Sg&pid=ImgRaw&r=0"),
                        (16,     'Tequila Patron Silver',                                               'Mexico',	    600,      	"Patrón Spirits Company",               30,             1280000,    00,                 3,                true        , "https://th.bing.com/th/id/OIP.dTurPlRpvrxUsYq49FJZQgHaHa?rs=1&pid=ImgDetMain"),
                        (17,     'Tequila Maestro Dobel Reposado',                                      'Mexico',  	    900,  		"Maestro Dobel Tequila",                35,             2000000,    00,                 3,                true        , "https://th.bing.com/th/id/OIP.8HD1vl032xHyv0g1D_0-fAHaJY?rs=1&pid=ImgDetMain"),
                        (18,     'Tequila Gran Centenario Anejo',                                       'Mexico',       950,    	"Gran Centenario",                      41.5,           1200000,    00,                 3,                true        , "https://th.bing.com/th/id/OIP.7ZOby99SNnFafTyjbnlohwHaJ2?w=202&h=269&c=7&r=0&o=5&dpr=1.3&pid=1.7"),
                        (19,     'Tequila Maestro Dobel 50 Cristalino',                                 'Mexico',       650,        "Tequila Clase Azul",	                40,             1000000,    00,                 3,                true        , "https://sanhruou.com/media/11913/catalog/Maestro-Dobel-50-Cristalino.jpg"),
                        (20,     'Tequila 1800 Cristalino',                                             'Pháp',         800,        "Tequila 1800",                         40,             1100000,    00,                 3,                true        , "https://th.bing.com/th/id/OIP.RdZ8kCEbt5T_5eQr6ZUo7AHaHa?rs=1&pid=ImgDetMain"),

						(21, 	 'Rượu Johnnie Walker Blue Label Elusive Umami Blended Scotch Whisky', 	'Scotland',     750,        "Johnnie Walker"	,                   43.8,           8400000,    05,                 4,                true        , "https://ruougiatot.com/wp-content/uploads/2023/10/ruou-Johnnie-Walker-Blue-Label-Ghost-and-Rare-Port-Dundas.jpg"),
						(22, 	 'Rượu Johnnie Walker Red Label Icon 2023', 							'Scotland',     750,        "Johnnie Walker"	,                   40,             390000,     10,                 4,                true        , "https://amp.sieuthiruoungoai.com/uploads/files/2022/10/13/JW-Red-Icon-2023.jpg"),
						(23, 	 'Rượu Johnnie Walker Gold Label Icon 40% - 750ml ',                     'Scotland',     750,        "Johnnie Walker"	,                   40,             1100000,    10,                 4,                true        , "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTs0MmUD2iAd9Mferhuw5VJd5hlVyTS9IqKrEYzCi_pcrPhPbZFDsRDwDgke7jrt0wClt8&usqp=CAU"),
						(24, 	 'Rượu Johnnie Walker Black Label Icon 40% - 750ml',                    'Scotland',     750,        "Johnnie Walker"	,                   40,             790000,     10,                 4,                true        , "https://winevn.com/wp-content/uploads/2020/09/R%C6%B0%E1%BB%A3u-Johnnie-Walker-Sons-XR-21.jpg"),
                        (25, 	 'Rượu Johnnie Walker Double Black',                                    'Scotland',     1000,       "Johnnie Walker"	,                   40,             850000,     10,                 4,                true        , "https://sanhruou.com/media/790/catalog/ruou-johnnie-walker-double-black.jpg"),
                        (26, 	 'Rượu Johnnie Walker & Sons XR 21 (750ml)',                            'Scotland',     500,        "Johnnie Walker"	,                   40,             2300000,    00,                 4,                false       , "https://winevn.com/wp-content/uploads/2020/09/R%C6%B0%E1%BB%A3u-Johnnie-Walker-Sons-XR-21.jpg"),
						(27, 	 'Rượu Johnnie Walker A Song Of Fire Game of Thrones (750ml)',          'Scotland',     750,        "Johnnie Walker"	,                   40,             950000,     00,                 4,                false       , "https://product.hstatic.net/200000398417/product/18_ae0f225bf4e7407997449f82962498ac_large.png"),
						(28, 	 'Rượu Johnnie Walker White Walker Game of Thrones (1000ml)',           'Scotland',     1000,       "Johnnie Walker"	,                   41.7,           1190000,    00,                 4,                false       , "https://sanhruou.com/media/1418/catalog/ruou-johnnie-walker-white-walker-1l.jpg"),
						(29, 	 'Rượu Johnnie Walker Double Black (Phiên bản 2021)',                   'Scotland',     750,        "Johnnie Walker"	,                   40,             920000,     00,                 4,                false       , "https://bizweb.dktcdn.net/100/337/663/products/ruou-johnnie-walker-double-black-1l-tet-2021.jpg?v=1632904856150"),
                        (30, 	 'Rượu Johnnie Walker Red Label - 3000ml',                              'Scotland',     3000,       "Johnnie Walker"	,                   40,             1650000,    00,                 4,                false       , "https://ruousaigon.com.vn/image/cache/catalog/san-pham/johnnies-walker/red-label/johnnie-walker-red-label-hop-don-3000ml-ruousaigon-com-vn-500x500.png");


INSERT INTO `NhaCungCap`    (`MaNCC`,   `TenNCC`,                                               `SoDienThoai`,           `Email`)
VALUES                      (1,         'Các nhà cung cấp khác ',             					'024.3826.7824',         'others@haprogroup.vn'),
							(2,         'Sabeco (Sài Gòn Beer Alcohol Beverage Corporation ',   '(+84) 24 39 745 877',   'sabeco@sabeco.com.vn'),
                            (3,         'Hapro (Hanoi Liquor Joint Stock Company)',             '024.3826.7984',         'doingoai@haprogroup.vn'),
                            (4,         'Vinaconex Wine',                                       '(84 24) 62849208',      'info@vinaconex.com.vn');


INSERT INTO `PhieuNhapKho`  (`MaPhieu`,     `NgayNhapKho`,          `TongGiaTri`, `MaNCC`, `MaQuanLy`)
VALUES                      (1,             '2023-01-20 00:00:00',  10000000,       2,      2),
                            (2,             '2023-02-20 00:00:00',  10000000,       3,      3),
                            (3,             '2023-02-22 00:00:00',  10000000,       3,      2),
                            (4,             '2024-01-25 00:00:00',  2500000,        4,      3),
                            (5,             '2024-01-25 00:00:00',  2500000,        4,      3),
                            (6,             '2024-01-25 00:00:00',  2500000,        4,      3),
                            (7,             '2024-01-25 00:00:00',  2500000,        4,      3),
                            (8,             '2024-01-25 00:00:00',  2500000,        4,      3),
                            (9,             '2024-01-25 00:00:00',  2500000,        4,      3),
                            (10,             '2024-01-25 00:00:00',  2500000,        4,      3);



INSERT INTO `CTPNK` (`SoLuong`,`DonGiaNhap`   ,`ThanhTien`, `MaPhieu`,       `MaSanPham`)
VALUES              (10,       100000,  			1000000,         1,          1),
                    (10,       100000,  			1000000,         1,          2),
                    (10,       100000,  			1000000,         1,          3),
                    (10,       100000,  			1000000,         1,          4),
                    (10,       100000,  			1000000,         1,          5),
                    (10,       100000,  			1000000,         1,          6),
                    (10,       100000,  			1000000,         1,          7),
                    (10,       100000,  			1000000,         1,          8),
                    (10,       100000,  			1000000,         1,          9),
                    (10,       100000,  			1000000,         1,          10),
                    (10,       100000,  			1000000,         2,          11),
                    (10,       100000,  			1000000,         2,          12),
                    (10,       100000,  			1000000,         2,          13),
                    (10,       100000,  			1000000,         2,          14),
                    (10,       100000,  			1000000,         2,          15),
                    (10,       100000,  			1000000,         2,          16),
                    (10,       100000,  			1000000,         2,          17),
                    (10,       100000,  			1000000,         2,          18),
                    (10,       100000,  			1000000,         2,          19),
                    (10,       100000,  			1000000,         2,          20),
                    (10,       100000,  			1000000,         3,          21),
                    (10,       100000,  			1000000,         3,          22),
                    (10,       100000,  			1000000,         3,          23),
                    (10,       100000,  			1000000,         3,          24),
                    (10,       100000,  			1000000,         3,          25),
                    (10,       100000,  			1000000,         3,          26),
                    (10,       100000,  			1000000,         3,          27),
                    (10,       100000,  			1000000,         3,          28),
                    (10,       100000,  			1000000,         3,          29),
                    (10,       100000,  			1000000,         3,          30),
                    (5 ,       100000,  			500000,          4,          1),
                    (5 ,       100000,  			500000,          4,          2),
                    (5 ,       100000,  			500000,          4,          3),
                    (5 ,       100000,  			500000,          4,          4),
                    (5 ,       100000,  			500000,          4,          5),
                    (6 ,       100000,  			500000,          5,          5),
                    (7 ,       100000,  			500000,          6,          5),
                    (8 ,       100000,  			500000,          7,          5),
                    (9,       	100000,  			500000,          8,          5),
                    (10 ,       100000,  			500000,          9,          5),
                    (10 ,       100000,  			500000,          10,          5);

                    
INSERT INTO `PhuongThucThanhToan` 	(`MaPhuongThuc`	 , `TenPhuongThuc`)
VALUES 								(		1,			"COD"),
									(		2,			"Chuyển khoản ngân hàng"),
									(		3, 			"Ví điện tử"),
									(		4, 			"Pay Pal"),
									(		5, 			"Zalo Pay"),
									(		6, 			"Thẻ tín dụng");


INSERT INTO `DichVuVanChuyen` 	(`MaDichVu`	 , `TenDichVu`)
VALUES 								(		1,			"Chuyển phát nhanh"),
									(		2,			"Giao hàng tiết kiệm");


INSERT INTO `DonHang`   (`MaDonHang`,        `NgayDat`,                `TongGiaTri`,       `MaKH`, 		`MaPhuongThuc`, `MaDichVu`, `DiaChiGiaoHang`)
VALUES                  (1,             '2023-09-02 10:00:00',     12800000,              5,            1		,	1				, "123 TPHCM"),
                        (2,             '2023-09-02 10:00:00',     20000000,              5,            1		,	1				, "123 TPHCM"),
                        (3,             '2023-09-02 10:00:00',     12000000,              4,            1		,	1				, "123 TPHCM"),
						(4,             '2023-09-02 10:00:00',     10000000,              6,            1		,	2				, "123 TPHCM"),
                        (5,             '2023-09-02 10:00:00',     11000000,              8,            1		,	2				, "123 TPHCM"),
                        (6,             '2023-09-02 12:00:00',     53000000,              8,            2		,	2				, "123 TPHCM"),

                        (7,             '2024-01-15 10:00:00',     70100000,              7,            5		,	2				, "123 TPHCM"),
                        (8,             '2024-01-16 10:00:00',     17850000,              8,            4  		,	2				, "123 TPHCM"),
                        (9,             '2024-01-19 10:00:00',     17850000,              9,            3		,	2				, "123 TPHCM"),
                        (10,            '2024-01-20 10:00:00',     17850000,              10,           2		,	2				, "123 TPHCM");

                        
INSERT INTO `TrangThaiDonHang` (`TrangThai`, 				`NgayCapNhat`, 			 `MaDonHang`)
VALUES 							('ChoDuyet', 				'2023-09-02 10:00:00', 	    1),
								('ChoDuyet', 				'2023-09-02 10:00:00', 	    2),
								('ChoDuyet', 				'2023-09-02 10:00:00', 	    3),
								('ChoDuyet', 				'2023-09-02 10:00:00', 	    4),
								('ChoDuyet', 				'2023-09-02 10:00:00', 	    5),

                                ('DaDuyet', 				'2023-09-02 15:00:00', 	    1),
								('DaDuyet', 				'2023-09-02 15:00:00', 	    2),
								('DaDuyet', 				'2023-09-02 15:00:00', 	    3),
								('DaDuyet', 				'2023-09-02 15:00:00', 	    4),
								('Huy', 				    '2023-09-02 11:00:00', 	    5),
								('ChoDuyet', 				'2023-09-02 12:00:00', 	    6),
                                ('DaDuyet', 				'2023-09-02 15:00:00', 	    6),

								('DangGiao', 				'2023-09-03 15:00:00', 	    1),
								('DangGiao', 				'2023-09-04 15:00:00', 	    2),
								('DangGiao', 				'2023-09-03 11:00:00', 	    3),
								('DangGiao', 				'2023-09-02 17:00:00', 	    4),
                                ('DangGiao', 				'2023-09-05 15:00:00', 	    6),

                                ('GiaoThanhCong', 			'2023-09-04 15:00:00', 	    1),
								('GiaoThanhCong', 			'2023-09-05 15:00:00', 	    2),
								('GiaoThanhCong', 			'2023-09-04 11:00:00', 	    3),
								('GiaoThanhCong', 			'2023-09-03 12:00:00', 	    4),
                                ('GiaoThanhCong', 			'2023-09-06 15:00:00', 	    6),

                                ('ChoDuyet', 				'2024-01-15 10:00:00', 	    7),
								('ChoDuyet', 				'2024-01-16 10:00:00', 	    8),
								('ChoDuyet', 				'2024-01-19 10:00:00', 	    9),
								('ChoDuyet', 				'2024-01-20 10:00:00', 	    10),

                                ('DaDuyet', 				'2024-01-15 15:00:00', 	    7),
                                ('DaDuyet', 				'2024-01-16 15:00:00', 	    8),
								('DaDuyet', 				'2024-01-19 15:00:00', 	    9),
								('Huy', 				    '2024-01-20 10:20:00', 	    10),

    							('DangGiao', 				'2024-01-16 15:00:00', 	    7),
                                ('DangGiao', 				'2024-01-16 15:00:00', 	    8),
                                ('GiaoThanhCong', 			'2024-01-17 15:00:00', 	    7),
                                ('GiaoThanhCong', 			'2024-01-18 15:00:00', 	    8),
								('Huy', 				    '2024-01-20 15:00:00', 	    9);


                                
INSERT INTO `CTDH`  (  `MaDonHang`,  `MaSanPham`,   `DonGia`  ,`SoLuong`,     `ThanhTien`)
VALUES              (1 ,        16,     1280000     ,10      ,       12800000),
                    (2 ,        17,     2000000     ,10      ,       20000000),
                    (3 ,        18,     1200000     ,10      ,       12000000),
                    (4 ,        19,     1000000     ,10      ,       10000000),
                    (5 ,        20,     1100000     ,10      ,       11000000),
                    (6 ,        20,     1100000     ,10      ,       11000000), 
                    (6 ,        21,     4200000     ,10      ,       42000000), 

                    (7 ,        26,     2300000     ,10      ,       23000000),
                    (7 ,        27,     950000      ,10      ,       9500000),
                    (7 ,        28,     1190000     ,10      ,       11900000),
                    (7 ,        29,     920000      ,10      ,       9200000), 
                    (7 ,        30,     1650000     ,10      ,       16500000), 

                    (8 ,        1,      850000      ,5      ,       4250000),
                    (8 ,        2,      120000      ,5      ,        600000),
                    (8 ,        3,      1100000     ,5      ,       5500000),
                    (8 ,        4,      650000      ,5      ,       3250000), 
                    (8 ,        5,      850000      ,5      ,       4250000), 

                    (9 ,        1,     850000       ,5      ,       4250000),
                    (9 ,        2,     120000       ,5      ,        600000),
                    (9 ,        3,     1100000      ,5      ,       5500000),
                    (9 ,        4,     650000       ,5      ,       3250000), 
                    (9 ,        5,     850000       ,5      ,       4250000), 

                    (10 ,        1,     850000      ,5      ,       4250000),
                    (10 ,        2,     120000      ,5      ,        600000),
                    (10 ,        3,     1100000     ,5      ,       5500000),
                    (10 ,        4,     650000      ,5      ,       3250000), 
                    (10 ,        5,     850000      ,5      ,       4250000);

