<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang'])) {
    // Nếu không có, chuyển hướng đến trang khác
    header("Location: http://localhost/UTH-PHP/src/controller/HomeController/HomeController.php");
    exit; // Đảm bảo dừng kịp thời việc thực thi của script
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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href=".../../public/template/frontEnd/manager/" />
  <!-- <link rel="stylesheet" href="./style.css" /> -->
  <title>Document</title>
  <style>
    body {
      font-family: "OpenSans", sans-serif;
    }

    .title {
      font-size: 18px;
      text-align: center;
      font-weight: bold;
      margin-bottom: 1px;
    }

    .rightAlignedText {
      font-size: 11px;
      margin-left: auto;
    }

    .table {
      display: table;
      width: auto;
      margin-right: 10px;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    .tableRow {
      width: 98vw;
      margin: auto;
      display: flex;
      flex-direction: row;
    }

    .tableCellBold {
      text-align: center;
      width: 100%;
      font-size: 14px;
      font-weight: bold;
      border-width: 1px;
      border-color: black;
      padding: 5px;
    }

    .tableCell {
      text-align: center;
      width: 100%;
      font-size: 12px;
      font-weight: bold;
      border-width: 1px;
      border-color: black;
      padding: 5px;
    }
  </style>
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
                  <div class="title">PHIẾU ĐỀ NGHỊ NHẬP KHO</div>

                  <!-- Date -->
                  <div class="rightAlignedText">
                    Ngày: ______ / ______ / ______
                  </div>

                  <!-- Kính gửi -->
                  <div style="
                        display: flex;
                        align-items: center;
                        margin-top: 15px;
                      ">
                    <div style="font-size: 11px; font-weight: bold">
                      Kính gửi :
                    </div>
                    <div style="
                          font-size: 15px;
                          font-weight: bold;
                          margin-left: 10px;
                        ">
                      PHÒNG KẾ TOÁN
                    </div>
                  </div>
                  <div style="margin-top: 20px">
                    <div style="display: flex; align-items: center">
                      <div style="
                            width: 5px;
                            height: 5px;
                            border-radius: 100%;
                            background-color: black;
                          "></div>
                      <div style="font-size: 11px; margin-left: 5px">
                        Nội dung:
                      </div>
                      <div style="font-size: 10px">
                        ...........................................................................................................................................................................................
                      </div>
                    </div>
                    <!-- Thêm các dòng dữ liệu tại đây -->
                  </div>

                  <!-- Table -->
                  <div class="table">
                    <div class="tableRow">
                      <div class="tableCellBold">STT</div>
                      <div class="tableCellBold">TÊN HÀNG HÓA</div>
                      <div class="tableCellBold">SỐ LƯỢNG</div>
                      <div class="tableCellBold">ĐƠN GIÁ</div>
                      <div class="tableCellBold">THÀNH TIỀN</div>
                    </div>
                    <!-- Thêm các hàng dữ liệu tại đây -->
                    <div style="
                          text-align: center;
                          width: 98vw;
                          font-size: 12px;
                          font-weight: bold;
                          border-width: 1px;
                          border-color: black;
                          padding: 5px;
                        ">
                      Tổng : {convertPrice(products.tongGiaTri)}
                    </div>
                  </div>

                  <!-- Diễn giải -->
                  <div style="font-size: 10px; font-weight: bold">
                    Diễn
                    giải:...........................................................................................................................................................................................
                  </div>
                  <!-- Thêm các dòng diễn giải tại đây -->

                  <!-- Chữ ký -->
                  <div style="
                        display: flex;
                        align-items: center;
                        margin-top: 40px;
                        justify-content: space-evenly;
                      ">
                    <div style="
                          flex: 1;
                          justify-content: center;
                          align-items: center;
                        ">
                      <div style="
                            font-size: 14px;
                            font-weight: bold;
                            display: inline-block;
                            text-align: center;
                          ">
                        NGƯỜI ĐỀ XUẤT
                      </div>
                      <div style="
                            font-size: 8px;
                            display: inline-block;
                            text-align: center;
                          ">
                        ký và ghi rõ họ tên
                      </div>
                    </div>
                    <div style="
                          flex: 1;
                          justify-content: center;
                          align-items: center;
                        ">
                      <div style="
                            font-size: 14px;
                            font-weight: bold;
                            display: inline-block;
                            text-align: center;
                          ">
                        TRƯỞNG BỘ PHẬN
                      </div>
                      <div style="
                            font-size: 8px;
                            display: inline-block;
                            text-align: center;
                          ">
                        ký và ghi rõ họ tên
                      </div>
                    </div>
                    <div style="
                          flex: 1;
                          justify-content: center;
                          align-items: center;
                        ">
                      <div style="
                            font-size: 14px;
                            font-weight: bold;
                            display: inline-block;
                            text-align: center;
                          ">
                        KẾ TOÁN KHO
                      </div>
                      <div style="
                            font-size: 8px;
                            display: inline-block;
                            text-align: center;
                          ">
                        ký và ghi rõ họ tên
                      </div>
                    </div>
                    <div style="
                          flex: 1;
                          justify-content: center;
                          align-items: center;
                        ">
                      <div style="
                            font-size: 14px;
                            font-weight: bold;
                            display: inline-block;
                            text-align: center;
                          ">
                        KẾ TOÁN TRƯỞNG
                      </div>
                      <div style="
                            font-size: 8px;
                            display: inline-block;
                            text-align: center;
                          ">
                        ký và ghi rõ họ tên
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

</html>
