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
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/AdminController/AdminIndex.php?page=Account
">
      <span class="MenuItemSidebar_title__LLBtx">Tài Khoản</span>
    </a>';
    }
    if ($feature[$i] === 6) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ProductController/ProductController.php
">
      <span class="MenuItemSidebar_title__LLBtx">Sản Phẩm</span>
    </a>';
    }
    if ($feature[$i] === 10) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ProductTypeController/ProductTypeController.php
">
      <span class="MenuItemSidebar_title__LLBtx">Loại Sản Phẩm</span>
    </a>';
    }
    if ($feature[$i] === 14) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/SupplierController/SupplierController.php
">
      <span class="MenuItemSidebar_title__LLBtx">Nhà Cung Cấp</span>
    </a>';
    }
    if ($feature[$i] === 18) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/InventoryController/InventoryController.php
">
      <span class="MenuItemSidebar_title__LLBtx">Phiếu Nhập Kho</span>
    </a>';
    }
    if ($feature[$i] === 21) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/cartControll/ManagerDonHangController.php
">
      <span class="MenuItemSidebar_title__LLBtx">Đơn Hàng</span>
    </a>';
    }
    if ($feature[$i] === 23) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ManagerController/NguoiDungController.php?page=User&numpage=1
">
      <span class="MenuItemSidebar_title__LLBtx">Người Dùng</span>
    </a>';
    }
    if ($feature[$i] === 27) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/AdminController/AdminIndex.php?page=Role
">
      <span class="MenuItemSidebar_title__LLBtx">Nhóm Quyền</span>
    </a>';
    }
    if ($feature[$i] === 31) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ThongKeController/ThongKeTongQuat.php
">
      <span class="MenuItemSidebar_title__LLBtx">Thống kê tổng quát</span>
    </a>';
    }
    if ($feature[$i] === 32) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ThongKeController/ThongKeDonHang.php
">
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
  <link rel="stylesheet" href="/UTH-PHP/src/view/admin/supplier/createSupplier.css" />
  <title>Document</title>
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
                          align-items: center;
                          gap: 1rem;
                          padding-bottom: 1rem;
                        "></div>
                    <div class="boxFeature">
                      <div>
                        <h2 style="font-size: 2.3rem">Nhà Cung Cấp</h2>
                        <p style="font-size: 1.1rem; font-weight: 700">
                          Nhà Cung Cấp / Xem và chỉnh sửa
                        </p>
                      </div>
                      <div>
                        <button class="btn__cancel" style="
                              font-family: Arial;
                              font-size: 1.5rem;
                              font-weight: 700;
                              border: 1px solid rgb(140, 140, 140);
                              background-color: white;
                              color: rgb(80, 80, 80);
                              padding: 1rem 2rem 1rem 2rem;
                              border-radius: 0.6rem;
                              cursor: pointer;
                            ">
                          Hủy
                        </button>
                      </div>
                    </div>
                    <form method="POST" class="createSupplierForm">
                      <h2>Thông Tin Sản Phẩm</h2>
                      <div class="container__boxFeature">
                        <div>
                          <p class="text">Tên Nhà Cung Cấp</p>
                          <input class="input" placeholder="Nhập tên nhà cung cấp" name="TenNhaCungCap" required />
                          <span style="margin-left: 1rem;font-weight: 700;color: rgb(150, 150, 150);">*</span>

                          <div>
                            <p class="text">Số Điện Thoại</p>
                            <input type="number" class="input" placeholder="Số điện thoại nhà cung cấp" name="SoDienThoai" required />
                          </div>
                          <div>
                            <p class="text">Email</p>
                            <input type="email" class="input" placeholder="Email nhà cung cấp" name="Email" required />
                          </div>
                        </div>
                        <button type="submit" style="
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: white;
                                background-color: rgb(65, 64, 64);
                                padding: 1rem 2rem 1rem 2rem;
                                border-radius: 0.6rem;
                                cursor: pointer;
                                margin-top: 20px;
                                width: 70%;
                              ">
                          Submit
                        </button>
                      </div>
                    </form>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/UTH-PHP/src/view/assets/js/supplier/script.js"></script>
<script>
  document.querySelector(".btn__cancel").addEventListener("click", () => {
    window.location.href = "/UTH-PHP/src/controller/SupplierController/SupplierController.php";
  })
  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
</script>

</html>
