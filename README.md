UTH-PHP — Website Bán Rượu

Đồ án môn Lập trình Web. Website bán hàng (rượu) xây dựng bằng PHP thuần theo mô hình MVC, kết nối MySQL qua PDO, có đầy đủ trang người dùng và trang quản trị (Admin).

Giới thiệu chức năng

Phía người dùng (Client):

Xem, tìm kiếm, lọc sản phẩm theo loại/nồng độ cồn, xem chi tiết sản phẩm (gallery nhiều ảnh + mô tả định dạng)
Đăng ký / đăng nhập / đăng xuất tài khoản
Giỏ hàng: thêm, cập nhật số lượng, xóa sản phẩm khỏi giỏ
Đặt hàng, chọn phương thức thanh toán & dịch vụ vận chuyển
Theo dõi, xem lại và hủy đơn hàng cá nhân
Quản lý thông tin cá nhân

Phía quản trị (Admin):

Quản lý sản phẩm & loại sản phẩm (CRUD đầy đủ, khóa/mở bán)
Quản lý đơn hàng toàn hệ thống (duyệt, cập nhật trạng thái, hủy đơn)
Quản lý nhà cung cấp & phiếu nhập kho
Quản lý tài khoản, người dùng, nhóm quyền & phân quyền
Xem báo cáo thống kê (doanh thu, sản phẩm bán chạy, trạng thái đơn hàng)

Tính năng nâng cao: phân trang danh sách sản phẩm, upload nhiều ảnh cho một sản phẩm (bảng AnhSanPham), trình soạn thảo CKEditor cho phần mô tả sản phẩm, giao diện responsive trên nhiều kích thước màn hình.

Công nghệ sử dụng
Backend: PHP thuần (mô hình MVC tự dựng), kết nối MySQL qua PDO
Frontend: HTML/CSS/JS thuần, jQuery, Bootstrap, SweetAlert2, CKEditor 4 (nhúng qua CDN)
Database: MySQL / MariaDB (XAMPP)
Yêu cầu môi trường
XAMPP (Apache + MySQL/MariaDB + PHP ≥ 7.4, khuyến nghị PHP 8.x)
Trình duyệt hiện đại bất kỳ (Chrome, Edge, Firefox...)
Hướng dẫn cài đặt & chạy dự án
Đặt thư mục dự án đúng vị trí Copy toàn bộ thư mục UTH-PHP vào trực tiếp trong thư mục htdocs của XAMPP:
   C:\xampp\htdocs\UTH-PHP\

⚠️ Toàn bộ code trong dự án lấy đường dẫn gốc bằng $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP'. Nếu đặt sai vị trí (ví dụ lồng thêm một cấp htdocs\htdocs\UTH-PHP, hoặc đổi tên thư mục khác UTH-PHP), toàn bộ đường dẫn include file, CSS, JS, ảnh sẽ sai và trang sẽ lỗi hàng loạt.

Khởi động XAMPP Mở XAMPP Control Panel, bấm Start cho cả Apache và MySQL.
Tạo cơ sở dữ liệu
Truy cập http://localhost/phpmyadmin
Tạo database mới tên uth_php_database (không dấu, chữ thường)
Vào tab Nhập (Import), chọn file SQLFile/WEB2_CreateDatabase_NoCommand.sql, bấm Thực hiện để dựng toàn bộ bảng + dữ liệu mẫu
Kiểm tra cấu hình kết nối database File src/config/MysqlConfig.php mặc định:
Host: localhost, Port: 3306
Username: root, Password: (rỗng)
Database: UTH_PHP_Database
Nếu MySQL trên máy bạn có cấu hình khác (đổi port, đặt mật khẩu cho root...), sửa lại các giá trị tương ứng trong file này.
Truy cập website
Trang người dùng: http://localhost/UTH-PHP/index.php hoặc http://localhost/UTH-PHP/src/view/home/homepage.php
Trang quản trị (Admin): http://localhost/UTH-PHP/src/controller/AdminController/Index.php
Tài khoản Admin mẫu có sẵn trong dữ liệu import — kiểm tra bảng taikhoan trong phpMyAdmin (cột MaQuyen ứng với quyền quản trị) để lấy tài khoản đăng nhập.
