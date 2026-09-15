<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(32, $_SESSION['chucNang'])) {

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <title>Thống kê đơn hàng</title>
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
                    <div style="display: flex; padding-top: 1rem; padding-bottom: 1rem;">
                      <h2>Thống kê đơn hàng</h2>
                    </div>
                    <div class="boxFeature">
                      <span class="text">Ngày Bắt Đầu</span>
                      <input id="from" type="date" style="height: 3rem; padding: 0.3rem;">
                      <span class="text">Ngày Kết Thúc</span>
                      <input id="to" type="date" style="height: 3rem; padding: 0.3rem;">
                      <div id="thongKeButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-magnifying-glass"></i></div>
                      <div id="resetButton" style="display: flex; justify-content: center; align-items: center; width: 50px; height: 3rem; padding: 0.3rem; color: white; font-weight: 700; background-color: white;"><i style="color: black; font-size: 20px;" class="fa-solid fa-rotate-right"></i></div>

                      <p style="font-size: 1.3rem; margin-left: auto; color: rgb(100, 100, 100); font-weight: 700;">
                        Mặc định được thống kê từ ngày 01/01/2010
                      </p>

                    </div>
                    <div class="boxTable">

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


    thongKeDonHang(fromValue, toValue);
  });


  resetButton.addEventListener("click", () => {
    from.value = "";
    to.value = "";
    thongKeDonHang("2010-01-01", formattedDate);
  })


  var currentDate = new Date();

  var year = currentDate.getFullYear();
  var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần
  var day = currentDate.getDate().toString().padStart(2, '0'); // Thêm số 0 phía trước nếu cần

  var formattedDate = year + '-' + month + '-' + day;

  thongKeDonHang("2010-01-01", formattedDate);

  function fetchTable(thongKe) {
    // Thực hiện các phép tính thống kê dữ liệu ở đây, hoặc bạn có thể truyền các biến đã tính sẵn vào hàm này.
    var totalHuy = 0;
    var totalChoDuyet = 0;
    var totalGiaoThanhCong = 0;
    var totalDonHang = 0;
    var totalDangGiao = 0;
    var totalDaDuyet = 0;

    var labels = [];
    var dataHuy = [];
    var dataChoDuyet = [];
    var dataGiaoThanhCong = [];
    var dataDonHang = [];
    var dataDangGiao = [];
    var dataDaDuyet = [];


    var tempHuy = 0;
    var tempChoDuyet = 0;
    var tempGiaoThanhCong = 0;
    var tempDonHang = 0;
    var tempDangGiao = 0;
    var tempDaDuyet = 0;

    // Duyệt qua từng phần tử trong mảng thongKe
    thongKe.forEach(function(item) {
      // Tính tổng số lượng đơn hàng
      totalDonHang += item.soLuongDon;

      // Kiểm tra trạng thái của đơn hàng và cập nhật các tổng tương ứng
      switch (item.trangThai) {
        case "Huy":
          totalHuy += item.soLuongDon;
          break;
        case "ChoDuyet":
          totalChoDuyet += item.soLuongDon;
          break;
        case "GiaoThanhCong":
          totalGiaoThanhCong += item.soLuongDon;
          break;
        case "DangGiao":
          totalDangGiao += item.soLuongDon;
          break;
        case "DaDuyet":
          totalDaDuyet += item.soLuongDon;
          break;
      }

      // Chuyển đổi ngày tháng từ dạng yyyy-MM-dd sang dd/MM/yyyy
      var ngayFormatted = formatNgay(item.ngayLapDon);

      //tempDonHang += item.soLuongDon;


      if (labels.length === 0) {
        labels.push(ngayFormatted);
        tempDonHang += item.soLuongDon;

        // Thêm số lượng đơn hàng vào các mảng dữ liệu tương ứng
        switch (item.trangThai) {
          case "Huy":
            tempHuy += item.soLuongDon;
            break;
          case "ChoDuyet":
            tempChoDuyet += item.soLuongDon;
            break;
          case "GiaoThanhCong":
            tempGiaoThanhCong += item.soLuongDon;
            break;
          case "DangGiao":
            tempDangGiao += item.soLuongDon;
            break;
          case "DaDuyet":
            tempDaDuyet += item.soLuongDon;
            break;
        }

      } else {




        // Nếu labels không chứa ngày này, thêm ngày vào labels
        if (!labels.includes(ngayFormatted)) {
          labels.push(ngayFormatted);
          dataDonHang.push(tempDonHang);
          dataHuy.push(tempHuy);
          dataChoDuyet.push(tempChoDuyet);
          dataGiaoThanhCong.push(tempGiaoThanhCong);
          dataDangGiao.push(tempDangGiao);
          dataDaDuyet.push(tempDaDuyet);

          tempDonHang = 0;
          tempHuy = 0;
          tempChoDuyet = 0;
          tempGiaoThanhCong = 0;
          tempDangGiao = 0;
          tempDaDuyet = 0;
        }

        tempDonHang += item.soLuongDon;
        // Thêm số lượng đơn hàng vào các mảng dữ liệu tương ứng
        switch (item.trangThai) {
          case "Huy":
            tempHuy += item.soLuongDon;
            break;
          case "ChoDuyet":
            tempChoDuyet += item.soLuongDon;
            break;
          case "GiaoThanhCong":
            tempGiaoThanhCong += item.soLuongDon;
            break;
          case "DangGiao":
            tempDangGiao += item.soLuongDon;
            break;
          case "DaDuyet":
            tempDaDuyet += item.soLuongDon;
            break;
        }


      }


    });

    dataDonHang.push(tempDonHang);
    dataHuy.push(tempHuy);
    dataChoDuyet.push(tempChoDuyet);
    dataGiaoThanhCong.push(tempGiaoThanhCong);
    dataDangGiao.push(tempDangGiao);
    dataDaDuyet.push(tempDaDuyet);


    var boxTable = document.querySelector('.boxTable');

    // Tạo các phần tử HTML và thêm nội dung vào
    var htmlContent = `
                <div style="display: flex; gap: 1.5rem;">
                <div class="dashboard-item canceled">
                    <div>
                        <p>Số đơn bị hủy</p>
                        <p>${totalHuy}</p>
                    </div>
                </div>
                <div class="dashboard-item waiting-approval">
                    <div>
                        <p>Số đơn chờ duyệt</p>
                        <p>${totalChoDuyet}</p>
                    </div>
                </div>
                <div class="dashboard-item approved">
                    <div>
                        <p>Số đơn đã duyệt</p>
                        <p>${totalDaDuyet}</p>
                    </div>
                </div>
                <div class="dashboard-item delivering">
                    <div>
                        <p>Số đơn đang giao</p>
                        <p>${totalDangGiao}</p>
                    </div>
                </div>
                <div class="dashboard-item delivered">
                    <div>
                        <p>Số đơn hoàn tất</p>
                        <p>${totalGiaoThanhCong}</p>
                    </div>
                </div>
                <div class="dashboard-item total">
                    <div>
                        <p>Tổng số đơn hàng</p>
                        <p>${totalDonHang}</p>
                    </div>
                </div>

                
                   
                </div>
                <div>
                    <canvas id="myChart" width="400" height="120"></canvas>
                </div>
            `;

    // Thêm nội dung vào boxTable
    boxTable.innerHTML = htmlContent;

    // Lấy tham chiếu đến thẻ canvas
    var ctx = document.getElementById('myChart').getContext('2d');


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
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
            label: 'Số đơn bị hủy',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: dataHuy
          },
          {
            label: 'Số đơn chờ duyệt',
            backgroundColor: '#00bcd4',
            borderColor: '#00bcd4',
            data: dataChoDuyet
          },
          {
            label: 'Số đơn đã duyệt',
            backgroundColor: '#8100ff',
            borderColor: '#8100ff',
            data: dataDaDuyet
          },
          {
            label: 'Số đơn đang giao',
            backgroundColor: '#ff9800',
            borderColor: '#ff9800',
            data: dataDangGiao
          },
          {
            label: 'Số đơn giao thành công',
            backgroundColor: '#8bc34a',
            borderColor: '#8bc34a',
            data: dataGiaoThanhCong
          },

          {
            label: 'Tổng số đơn hàng',
            backgroundColor: 'rgb(52, 51, 51)',
            borderColor: 'rgb(52, 51, 51)',
            data: dataDonHang
          },



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




  //Call API Thống kê đơn hàng
  function thongKeDonHang(from, to) {
    $.ajax({
      url: '../../model/ThongKeModel/ThongKeQuery/ThongKeQuery.php',
      type: 'GET',
      dataType: "json",
      data: {
        action: "thongKeDonHang",
        from: from,
        to: to,
      },
      success: function(response) {
        // Xử lý dữ liệu trả về từ API ở đây
        fetchTable(response.data);
      },
      error: function(xhr, status, error) {
        console.error('Lỗi khi gọi API: ', error);
      }
    });
  }

  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
</script>

</html>
