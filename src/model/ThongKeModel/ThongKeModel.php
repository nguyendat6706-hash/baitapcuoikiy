<?php
    $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
    require_once "$projectRoot/src/config/MysqlConfig.php";

    class ThongKeModel {

        
        private $db;

        function thongKePhieuNhapKho(){
            // Chuẩn bị câu truy vấn
            $query = "SELECT COUNT(*) as SoLuong FROM `PhieuNhapKho`; ";

            try {
                // Khởi tạo kết nối
                $this->db = MysqlConfig::getConnection();
                $statement = $this->db->prepare($query);

                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                $this->db = null;
            }
        }

        function thongKeTaiKhoan(){
            // Chuẩn bị câu truy vấn
            $query = "SELECT COUNT(*)  as SoLuong FROM `TaiKhoan`; ";

            try {
                // Khởi tạo kết nối
                $this->db = MysqlConfig::getConnection();
                $statement = $this->db->prepare($query);

                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                $this->db = null;
            }
        }

        function thongKeSanPham(){
            // Chuẩn bị câu truy vấn
            $query = "SELECT COUNT(*)  as SoLuong FROM `SanPham`; ";

            try {
                // Khởi tạo kết nối
                $this->db = MysqlConfig::getConnection();
                $statement = $this->db->prepare($query);

                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                $this->db = null;
            }
        }

        function thongKeNhaCungCap(){
            // Chuẩn bị câu truy vấn
            $query = "SELECT COUNT(*)  as SoLuong FROM `NhaCungCap`; ";

            try {
                // Khởi tạo kết nối
                $this->db = MysqlConfig::getConnection();
                $statement = $this->db->prepare($query);

                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                $this->db = null;
            }
        }


        function thongKeDonHang($from, $to){
   
            // Chuẩn bị câu truy vấn
            $query = "SELECT DATE(dh.NgayDat) AS ngayLapDon, tdh.TrangThai AS trangThai, COUNT(*) AS soLuongDon
                    FROM TrangThaiDonHang tdh
                    INNER JOIN DonHang dh ON tdh.MaDonHang = dh.MaDonHang
                    WHERE DATE(dh.NgayDat) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE())
                    AND tdh.NgayCapNhat = (
                        SELECT MAX(tdh2.NgayCapNhat)
                        FROM TrangThaiDonHang tdh2
                        WHERE tdh2.MaDonHang = tdh.MaDonHang
                    )
                    GROUP BY DATE(dh.NgayDat), tdh.TrangThai
                    ORDER BY DATE(dh.NgayDat)";
    
            try {
                // Khởi tạo kết nối
                $this->db = MysqlConfig::getConnection();
                $statement = $this->db->prepare($query);
    
                // Bind các giá trị tham số
                $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
                $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);
    
                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                $this->db = null;
            }
        }

    
        function thongKeDoanhThu($from, $to, $maLoaiSanPham){
            // Chuẩn bị kết nối
            $this->db = null;
    
            // Chuẩn bị câu truy vấn
            $query = "  SELECT DATE(dh.NgayDat) as NgayThongKe, SUM(ct.SoLuong) AS SoLuongDaBan, SUM(ct.ThanhTien) AS DoanhThu
                        FROM DonHang dh
                        JOIN TrangThaiDonHang tt ON dh.maDonHang = tt.maDonHang
                        JOIN CTDH ct ON dh.maDonHang = ct.maDonHang
                        JOIN SanPham sp ON sp.maSanPham = ct.MaSanPham
                        WHERE tt.ngayCapNhat = (
                                SELECT MAX(tdh2.ngayCapNhat)
                                FROM TrangThaiDonHang tdh2
                                WHERE tdh2.maDonHang = tt.maDonHang
                            )
                            AND tt.TrangThai = 'GiaoThanhCong'
                        AND DATE(dh.NgayDat) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE() )";
            if ($maLoaiSanPham != null){
                $query .= "AND sp.maLoaiSanPham = :maLoaiSanPham";
            }
            $query .="
                        GROUP BY DATE(dh.NgayDat)
                        ORDER BY DATE(dh.NgayDat);";
    
            try {
                // Khởi tạo kết nối
                $this->db = MysqlConfig::getConnection();
                $statement = $this->db->prepare($query);
    
                // Bind các giá trị tham số
                $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
                $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);

                if ($maLoaiSanPham != null){
                    $statement->bindValue(':maLoaiSanPham', $maLoaiSanPham, PDO::PARAM_INT);
                }

    
                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                $this->db = null;
            }
        }


        function thongKeChiTieu($from, $to, $maLoaiSanPham){
      
    
            // Chuẩn bị câu truy vấn
            $query = "SELECT DATE(pnk.ngayNhapKho) AS NgayNhap,
                                SUM(ct.SoLuong) AS SoLuongDaNhap,
                                SUM(ct.ThanhTien) AS ChiTieu
                        FROM PhieuNhapKho pnk
                        JOIN CTPNK ct ON pnk.MaPhieu = ct.MaPhieu
                        JOIN SanPham sp ON sp.maSanPham = ct.MaSanPham

                        WHERE DATE(pnk.ngayNhapKho) BETWEEN COALESCE(:minDate, '2010-01-01') AND COALESCE(:maxDate, CURRENT_DATE())";

            if ($maLoaiSanPham != null){
                $query .= "AND sp.maLoaiSanPham = :maLoaiSanPham";
            }

            $query .= " GROUP BY DATE(pnk.ngayNhapKho)
                        ORDER BY DATE(pnk.ngayNhapKho);";
    
            try {
                // Khởi tạo kết nối
                 $this->db = MysqlConfig::getConnection();
                $statement =  $this->db->prepare($query);
    
                // Bind các giá trị tham số
                $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
                $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);
                if ($maLoaiSanPham != null){
                    $statement->bindValue(':maLoaiSanPham', $maLoaiSanPham, PDO::PARAM_INT);
                }
                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                 $this->db = null;
            }
        }

    
        function thongKeSanPhamBanChay($from, $to, $maLoaiSanPham){
            try {
                // Base query
                $query = "SELECT sp.`MaSanPham` as `MaSanPham`, sp.`TenSanPham` as `TenSanPham`, t.`TenLoaiSanPham` as `LoaiSanPham`  ,SUM(ct.`SoLuong`) as `TongSoLuong`, SUM(ct.`ThanhTien`) as `TongDoanhThu` 
                FROM `DonHang` dh 
                JOIN `TrangThaiDonHang` tt ON dh.`MaDonHang` = tt.`MaDonHang`
                JOIN `CTDH` ct ON dh.`MaDonHang` = ct.`MaDonHang`
                JOIN `SanPham` sp ON sp.`MaSanPham` = ct.`MaSanPham` 
                JOIN `LoaiSanPham` t ON sp.`MaLoaiSanPham` = t.`MaLoaiSanPham` 

                WHERE  tt.`NgayCapNhat` = (
                    SELECT MAX(stt.`NgayCapNhat`) FROM `TrangThaiDonHang` stt
                    WHERE dh.`MaDonHang` = stt.`MaDonHang`
                ) AND tt.`TrangThai` = 'GiaoThanhCong'
                AND DATE(dh.`NgayDat`) BETWEEN COALESCE(:minDate ,'2010-01-01') AND COALESCE(:maxDate ,CURRENT_DATE)";
            if ($maLoaiSanPham != null){
                $query .= "AND sp.maLoaiSanPham = :maLoaiSanPham";
            }
            $query .= "
                GROUP BY sp.`MaSanPham`, sp.`TenSanPham`
                ORDER BY  `TongSoLuong` DESC, `TongDoanhThu` DESC;";
        
                // Khởi tạo kết nối
                $this->db = MysqlConfig::getConnection();
                $statement = $this->db->prepare($query);
        
                // Bind các giá trị tham số
                $statement->bindValue(':minDate', $from, PDO::PARAM_STR);
                $statement->bindValue(':maxDate', $to, PDO::PARAM_STR);
                if ($maLoaiSanPham != null){
                    $statement->bindValue(':maLoaiSanPham', $maLoaiSanPham, PDO::PARAM_INT);
                }
        
                // Thực thi truy vấn
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
                // Trả về kết quả
                return (object) [
                    "status" => 200,
                    "message" => "Thống kê thành công !!",
                    "data" => $result
                ];
            } catch (PDOException $e) {
                // Xử lý nếu có lỗi
                return (object) [
                    "status" => 400,
                    "message" => "Lỗi không thể thống kê đơn hàng",
                    "data" => []
                ];
            } finally {
                // Đóng kết nối
                $this->db = null;
            }
        }
        

    }
       
?>
