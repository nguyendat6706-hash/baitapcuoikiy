<?php

session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang'])) {
  // Nếu không có, chuyển hướng đến trang khác
  header("Location: http://localhost/UTH-PHP/src/controller/HomeController/HomeController.php");
  exit; // Đảm bảo dừng kịp thời việc thực thi của script
}
function loadPageDependOnFeature()
{
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

  <link rel="stylesheet" href="./../../view/assets/css/Admin.css" />
  <link rel="stylesheet" href="./../../view/assets/css/oneForAll.css" />
  <link rel="stylesheet" href="./../../view/assets/css/UserUpdate.css" />

  <!-- <link rel="stylesheet" href="../view/assets/Admin.css" /> -->

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
                    <form id="submit-form" action="../ManagerController/NguoiDungController.php" method="post">
                      <input type="hidden" name="action" value="createUser">
                      <div class="boxFeature">
                        <div>
                          <h2 style="font-size: 2.3rem">Tạo mới người dùng</h2>

                        </div>
                        <div>
                          <a style="
                              font-family: Arial;
                              font-size: 1.5rem;
                              font-weight: 700;
                              border: 1px solid rgb(140, 140, 140);
                              background-color: white;
                              color: rgb(80, 80, 80);
                              padding: 1rem 2rem 1rem 2rem;
                              border-radius: 0.6rem;
                              cursor: pointer;
                            " href="../ManagerController/NguoiDungController.php?page=User">


                            Hủy
                          </a>
                          <button id="updateUser_save" style="
                              margin-left: 1rem;
                              font-family: Arial;
                              font-size: 1.5rem;
                              font-weight: 700;
                              color: white;
                              background-color: rgb(65, 64, 64);
                              padding: 1rem 2rem 1rem 2rem;
                              border-radius: 0.6rem;
                              cursor: pointer;
                            ">
                            Lưu
                          </button>
                        </div>
                      </div>
                      <div class="boxTable">

                        <div style="
                            display: flex;
                            padding: 0rem 1rem 0rem 1rem;
                            justify-content: space-between;
                          ">
                          <div>
                            <p style="font-weight: 700; font-size: 2rem">
                              Thông tin người dùng
                            </p>
                            <div style="padding-left: 1rem">
                              <p class="text">Họ Tên</p>
                              <input id="HoTen" class="input" type="text" name="HoTen" style="width: 40rem" />
                              <span style="
                                  margin-left: 1rem;
                                  font-weight: 700;
                                  color: rgb(150, 150, 150);
                                ">*</span>
                              <div style="display: flex; gap: 2rem">
                                <div>
                                  <p class="text">Email</p>
                                  <input id="email" type="text" class="input" name="Email" onchange="checkEmailTonTai(this.value)" />

                                </div>
                                <div>
                                  <p class="text">Địa chỉ</p>
                                  <input id="diachi" class="input" name="DiaChi" />
                                </div>
                              </div>
                              <div id="Emailtontai"></div>
                              <div style="display: flex; gap: 4rem">

                                <div style="display: flex; gap: 2rem ; align-items: center; text-align: center;">
                                  <p class="text">Giới Tính</p>
                                  <input type="radio" id="gioitinh_male" name="Gender" value="male">
                                  <p for="html">Nam</p>
                                  <input type="radio" id="gioitinh_female" name="Gender" value="female" />
                                  <label for="css">Nữ</label><br>
                                </div>

                                <div>
                                  <p class="text">Ngày sinh</p>
                                  <input id="ngaysinh" type="date" class="input" name="NgaySinh" />
                                </div>
                              </div>
                              <div style="display: flex; gap: 2rem">
                                <div>
                                  <p class="text">Số điện thoại</p>
                                  <input id="sdt" class="input" style="width: 30rem" name="Sdt" />
                                </div>
                                <div>
                                  <p class="text">Đối tượng</p>
                                  <select name="DoiTuong" id="vaitro" class="input">
                                    <option value="" selected>Chọn đối tượng</option>
                                    <option value="QuanLy">Quản lý</option>
                                    <option value="NhanVienKyThuat">Nhân viên kỹ thuật</option>
                                    <option value="NhanVienKinhDoanh">Nhân viên kinh doanh</option>
                                    <option value="CEO">CEO</option>
                                  </select>

                                </div>


                              </div>
                            </div>

                          </div>
                          <div>


                          </div>
                        </div>
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
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
  }

  function validatePhoneNumber(phoneNumber) {
    const re = /^\d+$/;
    return re.test(phoneNumber);
  }

  function checkEmailTonTai(value) {
    if (value.trim() === "") {
      document.getElementById("Emailtontai").innerHTML = '<p id="authenticEmail"></p>';
      return;
    } else if (!/[^ ]+@[^ ]+\.[^ ]+/.test(value.trim())) {
      document.getElementById("Emailtontai").innerHTML = '<p style="color:red" id="authenticEmail">Email không hợp lệ</p>';
      email.focus();
      flat = false;
      event.preventDefault();
      return;
    }

    let url = "../ManagerController/NguoiDungController.php?page=User&action=checkEmail&Email=" + value;
    $.ajax({
      url: url,
      type: 'GET',
      success: function(data) {
        console.log(data);
        if (data == 404) {
          document.getElementById("Emailtontai").innerHTML = '<p id="authenticEmail" style="color:red">Email đã tồn tại</p>';
        } else if (data == 200) {
          document.getElementById("Emailtontai").innerHTML = '<p id="authenticEmail" style="color:green">Email có thể sử dụng</p>';
        } else if (!value.trim()) {
          document.getElementById("Emailtontai").innerHTML = "";
        }
      },
      error: function(xhr, status, error) {
        console.error('Error: ' + xhr.status + ' - ' + error);
      }
    });
  }


  document.getElementById("submit-form").addEventListener('submit', function check(event) {
    // let matkhau = document.getElementById("matkhau");
    //  let taikhoan = document.getElementById("taikhoan");
    let HoTen = document.getElementById("HoTen");
    let sdt = document.getElementById("sdt");
    let diachi = document.getElementById("diachi");
    let gioitinh_male = document.getElementById("gioitinh_male");
    let gioitinh_female = document.getElementById("gioitinh_female");
    let vaitro = document.getElementById("vaitro");
    let email = document.getElementById("email");
    let ngaysinh = document.getElementById("ngaysinh");
    let flat = true;
    if (!HoTen.value.trim()) {
      alert("Họ Tên không được để trống");
      HoTen.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!email.value.trim()) {
      alert("Email không được để trống");
      email.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!sdt.value.trim()) {
      alert("Số điện thoại không được để trống");
      sdt.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!validatePhoneNumber(sdt.value.trim())) {
      alert("Số điện thoại phải là số");
      sdt.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!diachi.value.trim()) {
      alert("Địa chỉ không được để trống");
      diachi.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!gioitinh_male.checked && !gioitinh_female.checked) {
      alert("Vui lòng chọn giới tính");
      event.preventDefault();
      return;
    }
    if (!vaitro.value.trim()) {
      alert("Vai trò không được để trống");
      vaitro.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!email.value.trim()) {
      alert("Email không được để trống");
      email.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!validateEmail(email.value.trim())) {
      alert("Email Không hợp lệ");
      email.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    let emailcheck = email.value.trim();
    if (!ngaysinh.value.trim()) {
      alert("Ngày sinh không được để trống");
      ngaysinh.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (document.getElementById("authenticEmail").textContent !== 'Email có thể sử dụng') {
      alert("Email đã tồn tại");
      email.focus();
      event.preventDefault();
      return;
    }
    alert("Bạn đã thêm thành công")
  });
  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
  /*
    let taikhoancheck = taikhoan.value.trim();
    let emailcheck = email.value.trim();
    checkTaiKhoanTonTai(taikhoancheck);
    checkEmailTonTai(emailcheck);
    if (document.getElementById("authenticAccount").textContent === 'Tên tài khoản đã tồn tại') {
      alert("Tên tài khoản đã tồn tại");
      taikhoan.focus();
      event.preventDefault();
        return;
    }
    if (document.getElementById("authenticEmail").textContent === 'Email đã tồn tại') {
      alert("Email đã tồn tại");
      email.focus();
      event.preventDefault();
        return;
    }
    else if (document.getElementById("authenticEmail").textContent === 'Email không hợp lệ') {
      alert("Email không hợp lệ");
      email.focus();
      event.preventDefault();
        return;
    }
});*/
  /*
  function checkTaiKhoanTonTai(value) {
      let url = "../controller/Index.php?page=User&action=checkTaiKhoan&tenTaiKhoan=" + value;
      if (value.trim() === "") {
        document.getElementById("taikhoantontai").innerHTML = '<p id="authenticAccount"></p>';
          return;
      }
      $.ajax({
          url: url,
          type: 'GET',
          success: function(data) {
            console.log(value);
              if (data == 404) {
                  document.getElementById("taikhoantontai").innerHTML = '<p id="authenticAccount" style="color:red">Tên tài khoản đã tồn tại</p>';
              } else if(data == 200){
                  document.getElementById("taikhoantontai").innerHTML = '<p id="authenticAccount" style="color:green">Tên đăng nhập có thể sử dụng</p>';
              }

          },
          error: function(xhr, status, error) {
              console.error('Error: ' + xhr.status + ' - ' + error);
          }
      });
  }
  

  // gan su kien
  document.getElementById("taikhoan").addEventListener("change", function() {
    let value = document.getElementById("taikhoan").value;
    checkTaiKhoanTonTai(value);
  });
  document.getElementById("email").addEventListener("change", function() {
    let value = document.getElementById("email").value;
    checkEmailTonTai(value);
  });
  */
</script>

</html>
