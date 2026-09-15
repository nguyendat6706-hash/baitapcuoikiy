<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(18, $_SESSION['chucNang'])) {

  // Nếu không có, chuyển hướng đến trang khác
  header("Location: http://localhost/UTH-PHP/src/controller/HomeController/HomeController.php");
  exit; // Đảm bảo dừng kịp thời việc thực thi của script
}

// hàm kiểm tra xem chức năng có tồn tại theo mã ( nhớ kĩ mã chức năng trong db rồi truyền vào check nếu có thì giá trị là true và ngược lại )
function checkFeatureExists($featureID) {
  // Kiểm tra xem $featureID có tồn tại trong mảng $_SESSION['chucNang'] không
  return in_array($featureID, $_SESSION['chucNang']);
}

function loadPageDependOnFeature() {
  $feature = array_map('intval', $_SESSION['chucNang']);
  $htmlContent = "";
  for ($i = 0; $i < count($feature); $i++) {
    if ($feature[$i] === 2) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/AdminController/AdminIndex.php?page=Account">
      <span class="MenuItemSidebar_title__LLBtx">Tài Khoản</span>
    </a>';
    }
    if ($feature[$i] === 6) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ProductController/ProductController.php">
      <span class="MenuItemSidebar_title__LLBtx">Sản Phẩm</span>
    </a>';
    }
    if ($feature[$i] === 10) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ProductTypeController/ProductTypeController.php">
      <span class="MenuItemSidebar_title__LLBtx">Loại Sản Phẩm</span>
    </a>';
    }
    if ($feature[$i] === 14) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/SupplierController/SupplierController.php">
      <span class="MenuItemSidebar_title__LLBtx">Nhà Cung Cấp</span>
    </a>';
    }
    if ($feature[$i] === 18) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/InventoryController/InventoryController.php">
      <span class="MenuItemSidebar_title__LLBtx">Phiếu Nhập Kho</span>
    </a>';
    }
    if ($feature[$i] === 21) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/cartControll/ManagerDonHangController.php">
      <span class="MenuItemSidebar_title__LLBtx">Đơn Hàng</span>
    </a>';
    }
    if ($feature[$i] === 23) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ManagerController/NguoiDungController.php?page=User&numpage=1">
      <span class="MenuItemSidebar_title__LLBtx">Người Dùng</span>
    </a>';
    }
    if ($feature[$i] === 27) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/AdminController/AdminIndex.php?page=Role">
      <span class="MenuItemSidebar_title__LLBtx">Nhóm Quyền</span>
    </a>';
    }
    if ($feature[$i] === 31) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ThongKeController/ThongKeTongQuat.php">
      <span class="MenuItemSidebar_title__LLBtx">Thống kê tổng quát</span>
    </a>';
      }
    if ($feature[$i] === 32) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ThongKeController/ThongKeDonHang.php">
      <span class="MenuItemSidebar_title__LLBtx">Thống kê đơn hàng</span>
    </a>';
    
    }
  }
  return $htmlContent;
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./adminDemo.css" />
    <link rel="stylesheet" href="./taoPhieuNhapKho.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Tạo phiếu nhập kho</title>
    <style> 
        a {
            text-decoration: none;  
        }
    </style>
<link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/admin-responsive.css?v=20260914">
  <script src="/UTH-PHP/src/view/assets/js/admin-responsive.js?v=20260914" defer></script>
  </head>

<body>
    <div id="root">
        <div>
            <div class="App">
                <div class="StaffLayout_wrapper__CegPk">
                    <div class="StaffHeader_wrapper__IQw-U">
                        <p class="StaffHeader_title__QxjW4">Dekanta</p>
                        <button class="StaffHeader_signOut__i2pcu">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right-from-bracket" class="svg-inline--fa fa-arrow-right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 2rem; height: 2rem; color: white">
                                <path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <div>
                            <div class="Manager_wrapper__vOYy">
                                <div class="Sidebar_sideBar__CC4MK">
                                    <?php
                                        echo loadPageDependOnFeature();
                                    ?>
                                </div>
                                <div style="padding-left: 16%; width: 100%; padding-right: 2rem">
                                    <div class="wrapper">
                                        <div style="
                                            display: flex;
                                            padding-top: 1rem;
                                            padding-bottom: 1rem;
                                        ">
                                            <h2>Phiếu Nhập Kho</h2>
                                            <div style="margin-left: auto">
                                                <button style="
                                                    font-family: Arial;
                                                    font-size: 1.5rem;
                                                    font-weight: 700;
                                                    color: white;
                                                    color: rgb(65, 64, 64);
                                                    border: 1px solid rgb(65, 64, 64);
                                                    background-color: white;
                                                    padding: 1rem;
                                                    border-radius: 0.6rem;
                                                    cursor: pointer;
                                                " onclick="back()">
                                                    Hủy
                                                </button>
                                              
                                            </div>
                                        </div>
                                      
                                        <div class="boxTable">
                                            <div style="
                                                background-color: rgb(236, 233, 233);
                                                width: 75%;
                                            ">
                                                <table style="
                                                    border-collapse: collapse;
                                                    width: 100%;
                                                    margin-top: 1rem;
                                                    border-radius: 1rem;
                                                ">
                                                    <thead>
                                                        <tr style="
                                                            background-color: rgb(40, 40, 40);
                                                            color: white;
                                                        ">
                                                            <th style="padding: 0.5rem width: 10%;">ID</th>
                                                            <th style="padding: 0.5rem">Tên Sản Phẩm</th>
                                                            <th style="padding: 0.5rem  width: 15%;">Đơn giá</th>
                                                            <th style="padding: 0.5rem  width: 10%;">Số lượng</th>
                                                            <th style="padding: 0.5rem  width: 15%;">Thành tiền</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="CTPNK">
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div style="
                                                width: 25%;
                                                background-color: rgb(236, 233, 233);
                                                padding: 1rem;
                                            ">
                                                <label>
                                                    <p style="font-size: 1.3rem; font-weight: 700">
                                                        Mã Phiếu
                                                    </p>
                                                    <input style="
                                                        height: 3rem;
                                                        padding: 0.5rem;
                                                        width: 100%;
                                                        background-color: white;
                                                        font-weight: 700;
                                                        margin-top: 0.5rem;
                                                    " value="" disabled="true" id="maPhieu" />
                                                </label>
                                                <label>
                                                    <p style="
                                                        font-size: 1.3rem;
                                                        font-weight: 700;
                                                        margin-top: 1rem;
                                                    ">
                                                        Tên Người Quản Lý
                                                    </p>
                                                    <input id="tenQuanLy" style="
                                                        height: 3rem;
                                                        padding: 0.5rem;
                                                        width: 100%;
                                                        background-color: white;
                                                        font-weight: 700;
                                                        margin-top: 0.5rem;
                                                    " disabled="true">
                                                        
                                                </label>
                                                <label>
                                                    <p style="
                                                        font-size: 1.3rem;
                                                        font-weight: 700;
                                                        margin-top: 1rem;
                                                    ">
                                                        Tổng Giá Trị
                                                    </p>
                                                    <input style="
                                                        height: 3rem;
                                                        padding: 0.5rem;
                                                        width: 100%;
                                                        background-color: white;
                                                        font-weight: 700;
                                                        margin-top: 0.5rem;
                                                    " min=0 value="0" disabled="true" id="tongGiaTri"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function back(){
        window.location.href= "../../../controller/InventoryController/InventoryController.php";
    }

    $(document).ready(function() {
        getAllNhaCungCap();
    
    });


    function getAllNhaCungCap() {
        $.ajax({
            url: '../../../model/SupplierModels/NhaCungCapQuery/NhaCungCapForInventory.php', 
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Xóa dữ liệu cũ trong select (nếu có)
                $('#selectNhaCungCap').empty();
                
                // Thêm option mặc định vào select
                $('#selectNhaCungCap').append($('<option>', {
                    value: '',
                    text: 'Chọn nhà cung cấp'
                }));
                
                // Lặp qua các dữ liệu nhà cung cấp từ API và thêm vào select
                $.each(response.data, function(index, nhaCungCap) {
                    $('#selectNhaCungCap').append($('<option>', {
                        value: nhaCungCap.MaNCC, // Thay 'id' bằng key của id trong dữ liệu nhà cung cấp
                        text: nhaCungCap.TenNCC // Thay 'name' bằng key của tên nhà cung cấp trong dữ liệu
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    fetchDataPhieu();
    fetchDataChiTietPhieu();
    function fetchDataPhieu(){
        $.ajax({
            url: '../../../model/InventoryModel/InventoryQuery/InventoryQueryGet.php',
            type: 'GET', // hoặc 'POST', 'PUT', 'DELETE' tùy thuộc vào yêu cầu của bạn
            dataType: 'json', // kiểu dữ liệu trả về từ API, có thể là 'json', 'xml', 'html', 'text', vv.
            data: {
                action: "get",
                maPhieu: <?php echo $_GET['maPhieu'] ?>
            },

            success: function(response) {
                console.log(response);

                document.getElementById("maPhieu").value = response.data.MaPhieu;
               document.getElementById("tenQuanLy").value = response.data.HoTen;
               document.getElementById("tongGiaTri").value = response.data.TongGiaTri;

                
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi khi gọi API
                console.error('Lỗi: ' + xhr.status + ' - ' + error);
            }
        });
    }

    function fetchDataChiTietPhieu(){
        $.ajax({
            url: '../../../model/InventoryModel/InventoryQuery/CTPNKQueryFetch.php',
            type: 'GET', // hoặc 'POST', 'PUT', 'DELETE' tùy thuộc vào yêu cầu của bạn
            dataType: 'json', // kiểu dữ liệu trả về từ API, có thể là 'json', 'xml', 'html', 'text', vv.
            data: {
                action: "get",
                maPhieu: parseInt((`<?php echo $_GET['maPhieu'] ?>`))
            },

            success: function(response) {
                console.log(response);
                data = response.data;
                var ctpnk = document.getElementById("CTPNK");
                data.forEach((ct) => {
                    ctpnk.innerHTML += `
                        <tr id="row${ct.MaSanPham}">
                            <td colspan="1" style="width: 10%; text-align: center; font-weight: 700; padding: 1rem;">${ct.MaSanPham}</td>
                            <td colspan="1" style="text-align: center; font-weight: 700; padding: 1rem;">${ct.TenSanPham}</td>
                            <td colspan="1" style="width: 15%; text-align: center; font-weight: 700; padding: 1rem;">
                                <input style="  pointer-events: none;
                                                height: 3rem;
                                                padding: 0.5rem;
                                                width: 100%;
                                                background-color: white;
                                                font-weight: 700;
                                                margin-top: 0.5rem;" type="number" min="1" id="donGia${ct.DonGiaNhap}" name="donGia" value="${ct.DonGiaNhap}">
                            </td>
                            <td colspan="1" style="width: 10%; text-align: center; font-weight: 700; padding: 1rem;">
                                <input style="  pointer-events: none;
                                                height: 3rem;
                                                padding: 0.5rem;
                                                width: 100%;
                                                background-color: white;
                                                font-weight: 700;
                                                margin-top: 0.5rem;" type="number" min="1" id="soLuong${ct.SoLuong}" name="soLuong" value="${ct.SoLuong}">
                            </td>
                            <td colspan="1" style="width: 15%; text-align: center; font-weight: 700; padding: 1rem;">
                                <input style="  pointer-events: none;
                                                height: 3rem;
                                                padding: 0.5rem;
                                                width: 100%;
                                                background-color: white;
                                                font-weight: 700;
                                                margin-top: 0.5rem;" type="number" min="0" id="thanhTien${ct.ThanhTien}" name="thanhTien" value="${ct.ThanhTien}">
                            </td>
                        </tr>
                    `;
                });
    
            
           

            },
            error: function(xhr, status, error) {
                // Xử lý lỗi khi gọi API
                console.error('Lỗi: ' + xhr.status + ' - ' + error);
            }
        });
    }

   



   

  
    


 
</script>

</html>
