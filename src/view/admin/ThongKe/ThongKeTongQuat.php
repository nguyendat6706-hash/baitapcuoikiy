<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(31, $_SESSION['chucNang'])) {

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


  <link rel="stylesheet" href="../../view/admin/InventoryView/adminDemo.css" />
  <link rel="stylesheet" href="../../view/admin/ThongKe/ThongKeDonHang.css" />
  <link rel="stylesheet" href="../../view/admin/ThongKe/ThongKeTongQuat.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <title>Thống kê tổng quát</title>
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



                    <!-- <div class="boxTable4">
                                                <h1 id="title">THỐNG KÊ TỔNG QUÁT</h1>
                                                <div class="thongKeTongQua">
                                                    <h3>Tài khoản</h3>
                                                    <h2 id="soLuongTaiKhoan"></h2>
                                                </div>
                                                <div class="thongKeTongQua">
                                                    <h3 >Sản phẩm</h3>
                                                    <h2 id="soLuongSanPham"></h2>

                                                </div>
                                                <div class="thongKeTongQua">
                                                    <h3>Nhà cung cấp</h3>
                                                    <h2 id="soLuongNhaCungCap"></h2>

                                                </div>
                                                <div class="thongKeTongQua">
                                                    <h3>Phiếu nhập kho</h3>
                                                    <h2 id="soLuongPhieuNhapKho"></h2>

                                                </div>
                                            </div> -->

                    <div style="display: flex; padding-top: 1rem; padding-bottom: 1rem;">
                      <h2>Thống kê tài chính</h2>
                    </div>


                    <div class="boxFeature">
                      <span class="text">Ngày Bắt Đầu</span>
                      <input id="from" type="date" style="height: 3rem; padding: 0.3rem;">
                      <span class="text">Ngày Kết Thúc</span>
                      <input id="to" type="date" style="height: 3rem; padding: 0.3rem;">
                      <select id="category-filter">
                        <!-- Hiển thị menu LoaiSanPham -->

                      </select>
                      <div id="thongKeButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-magnifying-glass"></i></div>
                      <div id="resetButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-rotate-right"></i></div>
                      <label for="category-filter">Loại sản phẩm:</label>

                      <p style="font-size: 1.3rem; margin-left: auto; color: rgb(100, 100, 100); font-weight: 700;">
                        Mặc định được thống kê từ ngày 01/01/2010
                      </p>

                    </div>
                    <div class="boxTable1">

                    </div>
                    <hr>

                    <div class="boxTable2">

                    </div>
                    <hr>

                    <div class="boxTable3">
                      <h1 id="title">THỐNG KÊ SẢN PHẨM BÁN CHẠY</h1>
                      <table id="sanPhamBanChayTable">
                        <thead>
                          <th>Mã sản phẩm</th>
                          <th>Tên sản phẩm</th>
                          <th>Loại sản phẩm</th>
                          <th>Tổng số lượng</th>
                          <th style="border-right: 0px">Tổng giá trị</th>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Gọi thongKeDoanhThu và thongKeChiTieu
    thongKeDoanhThu("2010-01-01", formattedDate, 0, function(dataDoanhThu) {
      thongKeChiTieu("2010-01-01", formattedDate, 0, function(dataChiTieu) {
        // Tại đây, cả hai cuộc gọi AJAX đã hoàn tất và bạn có thể thực hiện các hàm khác
        fetchTable(dataDoanhThu, dataChiTieu);
        // Hoặc bất kỳ hành động nào khác bạn muốn thực hiện
      });
    });


    thongKeSanPhamBanChay("2010-01-01", formattedDate, 0);
    getCategories()
    // thongKeNhaCungCap();
    // thongKeSanPham();

    // thongKeTaiKhoan();

    // thongKePhieuNhapKho();

  });

  const resetButton = document.getElementById("resetButton");
  const thongKeButton = document.getElementById("thongKeButton");
  const from = document.getElementById("from");
  const to = document.getElementById("to");


  thongKeButton.addEventListener("click", () => {
    // Kiểm tra xem người dùng đã nhập cả ngày bắt đầu và ngày kết thúc chưa
    if (from.value !== "" && to.value !== "") {
      // Chuyển các giá trị ngày thành đối tượng Date để so sánh
      var fromDate = new Date(from.value);
      var toDate = new Date(to.value);

      // Kiểm tra xem ngày kết thúc có lớn hơn ngày bắt đầu ít nhất 1 ngày không
      var oneDay = 24 * 60 * 60 * 1000; // Số mili giây trong 1 ngày
      if (toDate <= fromDate || (toDate.getTime() - fromDate.getTime()) < oneDay) {
        // Hiển thị cảnh báo nếu ngày kết thúc không hợp lệ
        Swal.fire({
          icon: 'warning',
          title: 'Lỗi!',
          text: 'Ngày kết thúc phải lớn hơn ngày bắt đầu ít nhất 1 ngày.',
        });
        return; // Dừng việc thực hiện tiếp theo nếu có lỗi
      }
    }


    fromValue = from.value !== "" ? from.value : "2010-01-01";
    toValue = to.value !== "" ? to.value : formattedDate;

    // Chuyển các giá trị ngày thành đối tượng Date để so sánh
    var fromDate = new Date(fromValue);
    var toDate = new Date(toValue);

    // Kiểm tra xem ngày kết thúc có lớn hơn ngày bắt đầu ít nhất 1 ngày không
    var oneDay = 24 * 60 * 60 * 1000; // Số mili giây trong 1 ngày
    if (toDate <= fromDate || (toDate.getTime() - fromDate.getTime()) < oneDay) {
      // Hiển thị cảnh báo nếu ngày kết thúc không hợp lệ
      Swal.fire({
        icon: 'warning',
        title: 'Lỗi!',
        text: 'Ngày kết thúc phải lớn hơn ngày bắt đầu ít nhất 1 ngày.',
      });
      return; // Dừng việc thực hiện tiếp theo nếu có lỗi
    }


    maLoaiSanPham = document.getElementById("category-filter").value;

    // Gọi thongKeDoanhThu và thongKeChiTieu
    thongKeDoanhThu(fromValue, toValue, maLoaiSanPham, function(dataDoanhThu) {
      thongKeChiTieu(fromValue, toValue, maLoaiSanPham, function(dataChiTieu) {
        // Tại đây, cả hai cuộc gọi AJAX đã hoàn tất và bạn có thể thực hiện các hàm khác
        fetchTable(dataDoanhThu, dataChiTieu);
        // Hoặc bất kỳ hành động nào khác bạn muốn thực hiện
      });
    });
    thongKeSanPhamBanChay(fromValue, toValue, maLoaiSanPham);
  });



  resetButton.addEventListener("click", () => {
    from.value = "";
    to.value = "";
    // Gọi thongKeDoanhThu và thongKeChiTieu
    thongKeDoanhThu("2010-01-01", formattedDate, 0, function(dataDoanhThu) {
      thongKeChiTieu("2010-01-01", formattedDate, 0, function(dataChiTieu) {
        // Tại đây, cả hai cuộc gọi AJAX đã hoàn tất và bạn có thể thực hiện các hàm khác
        fetchTable(dataDoanhThu, dataChiTieu);
        // Hoặc bất kỳ hành động nào khác bạn muốn thực hiện
      });
    });
    thongKeSanPhamBanChay("2010-01-01", formattedDate, 0);
  })

  var currentDate = new Date();

  var year = currentDate.getFullYear();
  var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần
  var day = currentDate.getDate().toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần

  var formattedDate = year + '-' + month + '-' + day;




  function fetchTable(thongKeDoanhThu, thongKeChiTieu) {

    // Thực hiện các phép tính thống kê dữ liệu ở đây, hoặc bạn có thể truyền các biến đã tính sẵn vào hàm này.
    var totalChiTieu = 0;
    var totalSanPhamNhap = 0;
    var totalDoanhThu = 0;
    var totalSanPhamBan = 0;

    var mapLabelsDoanhThu = new Map();
    var mapLabelsChiTieu = new Map();

    var mapLabelsSanPhamBan = new Map();
    var mapLabelsSanPhamNhap = new Map();


    var labels = [];
    var dataChiTieu = [];
    var dataSanPhamNhap = [];
    var dataDoanhThu = [];
    var dataSanPhamBan = [];

    // Duyệt qua từng phần tử trong mảng thongKeDoanhThu
    thongKeDoanhThu.forEach(function(item) {


      labels.push(item.NgayThongKe);

      totalDoanhThu += parseInt(item.DoanhThu);
      totalSanPhamBan += parseInt(item.SoLuongDaBan);

      mapLabelsDoanhThu.set(item.NgayThongKe, item.DoanhThu);
      mapLabelsSanPhamBan.set(item.NgayThongKe, item.SoLuongDaBan);


    });


    // Duyệt qua từng phần tử trong mảng thongKeChiTieu
    thongKeChiTieu.forEach(function(item) {
      labels.push(item.NgayNhap);

      totalChiTieu += parseInt(item.ChiTieu);
      totalSanPhamNhap += parseInt(item.SoLuongDaNhap);

      mapLabelsChiTieu.set(item.NgayNhap, item.ChiTieu);
      mapLabelsSanPhamNhap.set(item.NgayNhap, item.SoLuongDaNhap);
    });

    labels.sort(function(a, b) {
      return new Date(a) - new Date(b);
    });

    var uniqueLabels = [...new Set(labels)];

    uniqueLabels.forEach(function(time) {

      dataDoanhThu.push(mapLabelsDoanhThu.has(time) ? mapLabelsDoanhThu.get(time) : 0);
      dataChiTieu.push(mapLabelsChiTieu.has(time) ? mapLabelsChiTieu.get(time) : 0);

      dataSanPhamBan.push(mapLabelsSanPhamBan.has(time) ? mapLabelsSanPhamBan.get(time) : 0);
      dataSanPhamNhap.push(mapLabelsSanPhamNhap.has(time) ? mapLabelsSanPhamNhap.get(time) : 0);

    });



    var boxTable = document.querySelector('.boxTable1');
    var boxTable2 = document.querySelector('.boxTable2');

    function formatCurrency(amount) {
      // Sử dụng hàm toLocaleString để chuyển đổi số thành định dạng tiền tệ với đơn vị tiền tệ mặc định của trình duyệt
      return amount.toLocaleString('vi-VN', {
        style: 'currency',
        currency: 'VND'
      });
    }
    // Tạo các phần tử HTML và thêm nội dung vào
    var htmlContent = `
                <div style="display: flex; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; background-color: #e91e63; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng chi tiêu</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${formatCurrency(totalChiTieu)}</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; background-color: #8bc34a; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng doanh thu</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${formatCurrency(totalDoanhThu)}</p>
                        </div>
                    </div>
                </div>
                <div>
                        <canvas id="myChart1" width="400" height="120" margin-bottom: 40px;></canvas>
                </div>
            `;

    var htmlContent2 = ` 
            <div style="display: flex; gap: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; background-color: #00bcd4; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng số sản phẩm nhập kho</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${totalSanPhamNhap}</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; background-color: #ff9800; width: 60rem; padding: 1rem;">
                        <div>
                            <p style="color: white; font-weight: 700;">Tổng số sản phẩm bán được</p>
                            <p style="color: white; font-weight: 700; font-size: 2.5rem;">${totalSanPhamBan}</p>
                        </div>
                    </div>
                </div>
                <div>
                        <canvas id="myChart2" width="400" height="120" margin-bottom: 40px;></canvas>
                </div>`

    // Thêm nội dung vào boxTable
    boxTable.innerHTML = htmlContent;
    boxTable2.innerHTML = htmlContent2;

    // Lấy tham chiếu đến thẻ canvas
    var ctx1 = document.getElementById('myChart1').getContext('2d');
    var ctx2 = document.getElementById('myChart2').getContext('2d');


    uniqueLabels = uniqueLabels.map(function(label) {
      return formatNgay(label);
    });


    // Cấu hình các tùy chọn cho biểu đồ
    var options = {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    };

    // Tạo một biểu đồ đường mới
    var myChart = new Chart(ctx1, {
      type: 'line',
      data: {
        labels: uniqueLabels,
        datasets: [{
            label: 'Tổng chi tiêu',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: dataChiTieu
          },
          {
            label: 'Tổng doanh thu',
            backgroundColor: '#8bc34a',
            borderColor: '#8bc34a',
            data: dataDoanhThu
          }
        ]
      },
      options: options
    });
    // Tạo một biểu đồ đường mới
    var myChart = new Chart(ctx2, {
      type: 'line',
      data: {
        labels: uniqueLabels,
        datasets: [{
            label: 'Tổng số sản phẩm nhập kho',
            backgroundColor: '#00bcd4',
            borderColor: '#00bcd4',
            data: dataSanPhamNhap
          },
          {
            label: 'Tổng số sản phẩm bán được',
            backgroundColor: '#ff9800',
            borderColor: '#ff9800',
            data: dataSanPhamBan
          }
        ]
      },
      options: options
    });
  }

  // Hàm chuyển đổi ngày tháng từ yyyy-MM-dd sang dd/MM/yyyy
  function formatNgay(ngay) {
    var parts = ngay.split('-');
    return parts[2] + '/' + parts[1] + '/' + parts[0];
  }

  function thongKePhieuNhapKho() {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKePhieuNhapKho"
      },
      success: function(response) {
        console.log(response);
        PhieuNhapKho = document.getElementById("soLuongPhieuNhapKho");
        console.log(response.data.SoLuong);
        PhieuNhapKho.value = response.data.SoLuong;
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }

  function thongKeSanPham() {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKeSanPham"
      },
      success: function(response) {
        console.log(response);
        SanPham = document.getElementById("soLuongSanPham");
        console.log(response.data.SoLuong);
        SanPham.value = response.data.SoLuong;
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }

  function thongKeTaiKhoan() {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKeTaiKhoan"
      },
      success: function(response) {
        console.log(response);
        TaiKhoan = document.getElementById("soLuongTaiKhoan");
        console.log(response.data.SoLuong);
        TaiKhoan.value = response.data.SoLuong;
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }


  function thongKeNhaCungCap() {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKeNhaCungCap"
      },
      success: function(response) {
        console.log(response);
        nhaCungCap = document.getElementById("soLuongNhaCungCap");
        console.log(response.data.SoLuong);
        nhaCungCap.value = response.data.SoLuong;
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }


  function thongKeDoanhThu(from, to, maLoaiSanPham, callback) {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKeDoanhThu",
        from: from,
        to: to,
        maLoaiSanPham: maLoaiSanPham
      },
      success: function(response) {
        // Xử lý dữ liệu trả về từ API ở đây
        callback(response.data); // Gọi callback và truyền dữ liệu cho nó
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }

  function thongKeChiTieu(from, to, maLoaiSanPham, callback) {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKeChiTieu",
        from: from,
        to: to,
        maLoaiSanPham: maLoaiSanPham

      },
      success: function(response) {
        // Xử lý dữ liệu trả về từ API ở đây
        callback(response.data); // Gọi callback và truyền dữ liệu cho nó
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }

  function thongKeSanPhamBanChay(from, to, maLoaiSanPham) {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKeSanPhamBanChay",
        from: from,
        to: to,
        maLoaiSanPham: maLoaiSanPham

      },
      success: function(response) {
        console.log(response);
        // Lấy thẻ tbody của bảng
        var tbody = document.getElementById("sanPhamBanChayTable").getElementsByTagName('tbody')[0];
        tbody.innerHTML = ""; // Xóa dữ liệu cũ trước khi thêm dữ liệu mới

        // Lặp qua dữ liệu từ API để tạo các dòng trong tbody của bảng
        for (var i = 0; i < response.data.length; i++) {
          var row = tbody.insertRow();
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);
          var cell4 = row.insertCell(3);
          var cell5 = row.insertCell(4);

          cell1.innerHTML = response.data[i].MaSanPham;
          cell2.innerHTML = response.data[i].TenSanPham;
          cell3.innerHTML = response.data[i].LoaiSanPham;
          cell4.innerHTML = response.data[i].TongSoLuong;
          cell5.innerHTML = formatCurrency(parseInt(response.data[i].TongDoanhThu));

          if (i % 2 == 0) {
            cell1.style.backgroundColor = "whitesmoke";
            cell2.style.backgroundColor = "whitesmoke";
            cell3.style.backgroundColor = "whitesmoke";
            cell4.style.backgroundColor = "whitesmoke";
            cell5.style.backgroundColor = "whitesmoke";

          }


          cell1.style.borderRight = "2px solid black";
          cell2.style.borderRight = "2px solid black";
          cell3.style.borderRight = "2px solid black";
          cell4.style.borderRight = "2px solid black";
          cell5.style.borderRight = "0px";

          cell1.style.borderBottom = "2px solid black";
          cell2.style.borderBottom = "2px solid black";
          cell3.style.borderBottom = "2px solid black";
          cell4.style.borderBottom = "2px solid black";
          cell5.style.borderBottom = "2px solid black";


        }
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }

  function formatCurrency(amount) {
    // Sử dụng hàm toLocaleString để chuyển đổi số thành định dạng tiền tệ với đơn vị tiền tệ mặc định của trình duyệt
    return amount.toLocaleString('vi-VN', {
      style: 'currency',
      currency: 'VND'
    });
  }



  function getCategories() {
    $.ajax({
      url: "../../model/ProductTypeModel/LoaiSanPhamQuery/LoaiSanPhamModelQuery.php",
      method: "GET",
      dataType: "json",
      data: {
        action: "noPaging"
      },
      success: function(response) {
        var categoryFilter = $('#category-filter');
        var htmlContent = '';

        // Duyệt qua danh sách loại sản phẩm và tạo option cho select
        $.each(response.data, function(index, category) {
          htmlContent += `<option value="${category.MaLoaiSanPham}">${category.TenLoaiSanPham}</option>`;
        });

        // Thêm tùy chọn "Tất cả"
        htmlContent = '<option value="0">Tất cả</option>' + htmlContent;

        // Thiết lập nội dung HTML cho select
        categoryFilter.html(htmlContent);
      },
      error: function(xhr, status, error) {
        console.error("Error:", error);
      }
    });
  }

  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
</script>

</html>
