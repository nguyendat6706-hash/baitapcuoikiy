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
  <link rel="stylesheet" href="/UTH-PHP/src/view/admin/InventoryView/adminDemo.css" />
  <link rel="stylesheet" href="../../view/admin/InventoryView/phieunhapkho.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Quản lý phiếu nhập kho</title>
  <style>
    .MenuItemSidebar_menuItem__56b1m {
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
                <div style="padding-left: 16%; width: 100%; padding-right: 2rem;margin-top: 18px;">
                  <div class="wrapper">
                    <div style="
                                              display: flex;
                                              padding-top: 1rem;
                                              padding-bottom: 1rem;
                                            ">
                      <h2>Phiếu Nhập Kho</h2>

                      <?php

                      if (checkFeatureExists(19)) {
                        echo '
                                                        <button id="taoPhieuNhapKho" style="
                                                            margin-left: auto;
                                                            font-family: Arial;
                                                            font-size: 1.5rem;
                                                            font-weight: 700;
                                                            color: white;
                                                            background-color: rgb(65, 64, 64);
                                                            padding: 1rem;
                                                            border-radius: 0.6rem;
                                                            cursor: pointer;
                                                        " onclick="toCreate()">
                                                            Tạo Phiếu Nhập
                                                        </button>
                                                    ';
                      }
                      ?>


                    </div>
                    <div class="boxFeature">
                      <div>
                        <label>
                          <span style="font-size: 1.7rem; font-weight: 700;margin-right: 8px;">
                            Đơn Trong Tháng :
                          </span>
                          <input id="date" class="input" type="month" style="text-indent: 5px;" />
                        </label>
                      </div>
                      <div style="margin-left: auto"></div>
                    </div>
                    <div class="Admin_boxTable__hLXRJ boxTable">
                      <table class="Table_table__BWPy table table-striped">
                        <thead class="Table_head__FTUog">
                          <tr>
                            <th style="cursor: pointer;" class="Table_th__hCkcg sortMaPhieu">Mã Phiếu<i class="fa-solid fa-caret-down fa-rotate-180"></i></th>
                            <th style="cursor: pointer;" class="Table_th__hCkcg sortNgayNhapKho">Ngày Nhập Kho<i class="fa-solid fa-caret-down fa-rotate-180"></i></th>
                            <th class="Table_th__hCkcg">Nhà cung cấp</th>
                            <th class="Table_th__hCkcg">Người quản lý</th>
                            <th style="cursor: pointer;" class="Table_th__hCkcg sortTongGiaTri">Tổng giá trị<i class="fa-solid fa-caret-down fa-rotate-180"></i></th>
                            <th class="Table_th__hCkcg">Thao tác</th>
                          </tr>
                        </thead>
                        <tbody id="tableBody" class="tableProduct"></tbody>
                      </table>
                      <div class="pagination"></div>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
    function toCreate() {
      window.location.href = "/UTH-PHP/src/view/admin/InventoryView/taoPhieuNhapKho.php";
    }



    document.getElementById("date").addEventListener("change", (event) => {
      const selectedDate = event.target.value;
      currentPage = 1;
      fetchDataAndUpdateTable(currentPage, selectedDate);
    });


    var currentPage = 1;
    fetchDataAndUpdateTable(currentPage, "");

    // Hàm tạo nút phân trang
    function createPagination(currentPage, totalPages) {
      var paginationContainer = document.querySelector('.pagination');
      var date = document.getElementById('date').value;
      // Xóa nút phân trang cũ (nếu có)
      paginationContainer.innerHTML = '';
      if (totalPages > 1) {
        // Tạo nút cho từng trang và thêm vào chuỗi HTML
        var paginationHTML = '';
        for (var i = 1; i <= totalPages; i++) {
          paginationHTML += '<button class="pageButton">' + i + '</button>';
        }
        // Thiết lập nút phân trang vào paginationContainer
        paginationContainer.innerHTML = paginationHTML;
        // Thêm sự kiện click cho từng nút phân trang
        paginationContainer.querySelectorAll('.pageButton').forEach(function(button, index) {
          button.addEventListener('click', function() {
            // Gọi hàm fetchDataAndUpdateTable khi người dùng click vào nút phân trang
            fetchDataAndUpdateTable(index + 1, date); // Thêm 1 vào index để chuyển đổi về trang 1-indexed
          });
        });
        // Đánh dấu trang hiện tại
        paginationContainer.querySelector('.pageButton:nth-child(' + currentPage + ')').classList.add('active'); // Sửa lại để chỉ chọn trang hiện tại
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      const sortMaPhieu = document.querySelector(".sortMaPhieu");
      const sortNgayNhapKho = document.querySelector(".sortNgayNhapKho");
      const sortTongGiaTri = document.querySelector(".sortTongGiaTri");

      sortMaPhieu.addEventListener("click", function() {
        handleSort("MaPhieu");
      });

      sortNgayNhapKho.addEventListener("click", function() {
        handleSort("NgayNhapKho");
      });

      sortTongGiaTri.addEventListener("click", function() {
        handleSort("TongGiaTri");
      });

      function handleSort(sortField) {
        const sortOrder = document.querySelector(".fa-caret-down").classList.contains("fa-rotate-180") ? "DESC" : "ASC";
        const sortIcon = document.querySelectorAll(".fa-caret-down");



        // Thực hiện xoay mũi tên và gửi yêu cầu sắp xếp
        if (sortOrder === "ASC") {
          sortIcon.forEach(icon => {
            icon.classList.add("fa-rotate-180");
          });
        } else {
          // Xoay biểu tượng chỉ mũi tên
          sortIcon.forEach(icon => {
            icon.classList.remove("fa-rotate-180");
          });
        }

        const sort = sortField + sortOrder;

        // Gửi yêu cầu sắp xếp dữ liệu
        fetchDataAndUpdateTable(1, document.getElementById('date').value, sort);
      }
    });


    // Hàm để xóa hết các dòng trong bảng
    function clearTable() {
      var tableBody = document.querySelector('.Table_table__BWPy tbody');
      tableBody.innerHTML = ''; // Xóa nội dung trong tbody
    }

    function toUpdate(maPhieu) {
      window.location.href = `/UTH-PHP/src/view/admin/InventoryView/chiTietPhieuNhapKho.php?maPhieu=${maPhieu}`;
    }



    function getAllPhieuNhapKho(page, date, sort) {
      $.ajax({
        url: '../../model/InventoryModel/InventoryModel.php',
        type: 'GET',
        dataType: "json",
        data: {
          action: "fetch",
          page: page,
          date: date,
          sort: sort || ""
        },
        success: function(response) {
          var data = response.data;
          var tableBody = document.getElementById("tableBody"); // Lấy thẻ tbody của bảng
          var tableContent = ""; // Chuỗi chứa nội dung mới của tbody

          data.forEach(function(record, index) {
            var trClass = (index % 2 !== 0) ? "Table_data_quyen_1" : "Table_data_quyen_2"; // Xác định class của hàng
            var ngayTao = new Date(record.NgayTao);
            var ngayTaoFormatted = ngayTao.toLocaleString();
            // Xác định trạng thái và văn bản của nút dựa trên trạng thái của tài khoản
            var buttonText = (record.TrangThai === 0) ? "Mở khóa" : "Khóa";
            var buttonClass = (record.TrangThai === 0) ? "unlock" : "block";
            var buttonData = (record.TrangThai === 0) ? "unlock" : "block";
            var trContent = `
                <form id="updateForm" method="post" action="FormUpdateTaiKhoan.php">
                  <tr style="height: 20%"; max-height: 20%;>
                    <td class="${trClass}" style="width: 10%;">${record.MaPhieu}</td>
                    <td class="${trClass}">${formatDateTime(record.NgayNhapKho)}</td>
                    <td class="${trClass}" style="width: 30%;">${record.TenNCC}</td>
                    <td class="${trClass}">${record.TenQuanLy}</td>
                    <td class="${trClass}">${formatMoney(record.TongGiaTri)}</td>`;
            if (record.Quyen !== "Admin") {
              trContent += `
                  <td class="${trClass}">
                    <button type="button" class="edit btn btn-primary" onclick="toUpdate(${record.MaPhieu})">Chi tiết</button>
                  </td>`;
            } else {
              trContent += `<td class="${trClass}"></td>`; // Tạo một ô trống nếu quyền là "Admin"
            }
            trContent += `</tr></form>`;
            // Nếu chỉ có ít hơn 5 phần tử và đã duyệt đến phần tử cuối cùng, thêm các hàng trống vào
            if (data.length < 5 && index === data.length - 1) {
              for (var i = data.length; i < 5; i++) {
                var emptyTrClass = (i % 2 !== 0) ? "Table_data_quyen_1" : "Table_data_quyen_2"; // Xác định class của hàng trống
                trContent += `
                    <form id="emptyForm" method="post" action="FormUpdateTaiKhoan.php">
                      <tr style="height: 20%"; max-height: 20%;>
                        <td class="${emptyTrClass}" style="width: 130px;"></td>
                        <td class="${emptyTrClass}"></td>
                        <td class="${emptyTrClass}"></td>
                        <td class="${emptyTrClass}"></td>
                        <td class="${emptyTrClass}"></td>
                        <td class="${emptyTrClass}"></td>
                        <td class="${emptyTrClass}"></td>
                      </tr>
                    </form>`;
              }
            }
            tableContent += trContent; // Thêm nội dung của hàng vào chuỗi tableContent
          });

          if (data.length === 0) {
            // Nếu không có phiếu nhập kho nào, in ra thông báo
            tableContent = `<tr><td colspan="7" style="text-align: center;">Không có phiếu nhập kho phù hợp</td></tr>`;
          }

          // Thiết lập lại nội dung của tbody bằng chuỗi tableContent
          tableBody.innerHTML = tableContent;
          // Tạo phân trang
          createPagination(page, response.totalPages);
        },
        error: function(xhr, status, error) {
          console.error('Lỗi khi gọi API: ', error);
        }
      });
    }

    // Hàm để gọi getAllTaiKhoan và cập nhật dữ liệu và phân trang
    function fetchDataAndUpdateTable(page, date, sort) {
      //Clear dữ liệu cũ
      clearTable();

      // Gọi hàm getAllTaiKhoan và truyền các giá trị tương ứng
      getAllPhieuNhapKho(page, date, sort);
    }

    function formatDateTime(dateTimeString) {
      const dateTime = new Date(dateTimeString);
      const options = {
        hour12: false,
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      };
      return new Intl.DateTimeFormat('vi-VN', options).format(dateTime);
    }


    function formatMoney(amount) {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
      }).format(amount);
    }

    document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
      // Redirect to the desired page
      window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
    });
  </script>
</body>

</html>
