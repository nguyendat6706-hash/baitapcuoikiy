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
                      <input type="hidden" name="action" value="updateUser">
                      <input type="hidden" name="MaNguoiDung" id="MaNguoiDung" value="<?php echo $DataNguoiDung['MaNguoiDung'] ?>" />
                      <input type="hidden" name="MaTaiKhoan" id="MaTaiKhoan" value="<?php echo $ThongTinTaiKhoanHienTai[0]['MaTaiKhoan'] ?>" />
                      <div class="boxFeature">
                        <div>
                          <h2 style="font-size: 2.3rem">Sửa / Xem
                            Chi tiết người dùng</h2>

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
                      <div id="Update_input" class="boxTable">

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
                              <input id="HoTen" class="input" type="text" name="HoTen" style="width: 40rem" value="<?php echo $DataNguoiDung['HoTen']  ?>" />
                              <span style="
                                  margin-left: 1rem;
                                  font-weight: 700;
                                  color: rgb(150, 150, 150);
                                ">*</span>
                              <div style="display: flex; gap: 2rem">
                                <div>
                                  <p class="text">Ngày sinh</p>
                                  <input id="ngaysinh" type="date" class="input" name="NgaySinh" value="<?php echo $DataNguoiDung['NgaySinh'] ?>" />
                                </div>
                                <div>
                                  <p class="text">Địa chỉ</p>
                                  <input class="input" id="diachi" name="DiaChi" value="<?php echo $DataNguoiDung['DiaChi'] ?> " />
                                </div>
                              </div>
                              <div style="display: flex; gap: 4rem">

                                <div style="display: flex; gap: 2rem ; align-items: center; text-align: center;">
                                  <p class="text">Giới Tính</p>
                                  <input type="radio" id="gioitinh_male" name="Gender" value="male" <?php echo $DataNguoiDung['GioiTinh'] === "Male" ? 'checked' : "" ?>>
                                  <label for="html">Male</label>
                                  <input type="radio" id="gioitinh_female" name="Gender" value="female" <?php echo $DataNguoiDung['GioiTinh'] === "Female" ? 'checked' : "" ?> />
                                  <label for="css">Female</label><br>
                                </div>

                                <div>
                                  <p class="text">Số điện thoại</p>
                                  <input id="sdt" class="input" style="width: 30rem" name="Sdt" value="<?php echo $DataNguoiDung['SoDienThoai'] ?> " />
                                </div>
                              </div>
                              <div class="newData" style="display: flex; gap: 2rem">
                                <div>
                                  <p class="text">Email</p>
                                  <input id="email" type="text" readonly class="input" name="Email" value="<?php echo $DataNguoiDung['Email'] ?> " />
                                  <p class="text">Tài Khoản đang sở hữu</p>
                                  <select name="TaiKhoan" id="taikhoan" class="input">
                                    <?php
                                    // if ($DataNguoiDung['DoiTuong'] == "KhachHang") {
                                    //   foreach ($DataTaiKhoan as $record) {
                                    //     if ($record['MaTaiKhoan'] == $DataNguoiDung['MaTaiKhoan']) {
                                    //       echo "<option selected value=" . $record["MaTaiKhoan"] . ">" . $record["TenDangNhap"] . "</option>";
                                    //          }
                                    //       }
                                    //         } else {
                                    if ($DataNguoiDung['DoiTuong'] !== "KhachHang") {
                                      if ($DataNguoiDung['MaTaiKhoan'] == null) {
                                        echo '<option selected value="">Chọn tài khoản</option>';
                                      } else {

                                        echo "<option value=" . $DataNguoiDung["MaTaiKhoan"] . ">" .  $ThongTinTaiKhoanHienTai[0]['TenDangNhap'] . "</option>";
                                      }

                                      foreach ($DataTaiKhoan as $record) {

                                        echo "<option value=" . $record["MaTaiKhoan"] . ">" . $record["TenDangNhap"] . "</option>";
                                      }
                                    } else {
                                      echo "<option value=" . $DataNguoiDung["MaTaiKhoan"] . ">" .  $ThongTinTaiKhoanHienTai[0]['TenDangNhap'] . "</option>";
                                    }






                                    ?> </select>

                                </div>
                                <div>

                                  <p class="text">Đối tượng</p>
                                  <select name="DoiTuong" id="doituong" class="input">
                                    <?php
                                    if ($DataNguoiDung['DoiTuong'] != 'KhachHang') {
                                      echo '<option value="QuanLy" ' . ($DataNguoiDung['DoiTuong'] == 'QuanLy' ? 'selected' : '') . '>Quản lý</option>';
                                      echo '<option value="NhanVienKyThuat" ' . ($DataNguoiDung['DoiTuong'] == 'NhanVienKyThuat' ? 'selected' : '') . '>Nhân viên kỹ thuật</option>';
                                      echo '<option value="NhanVienKinhDoanh" ' . ($DataNguoiDung['DoiTuong'] == 'NhanVienKinhDoanh' ? 'selected' : '') . '>Nhân viên kinh doanh</option>';
                                      echo '<option value="CEO" ' . ($DataNguoiDung['DoiTuong'] == 'CEO' ? 'selected' : '') . '>CEO</option>';
                                    } else {
                                      echo '<option value="KhachHang" ' . ($DataNguoiDung['DoiTuong'] == 'KhachHang' ? 'selected' : '') . '>Khách Hàng</option>';
                                    }
                                    ?>
                                  </select>
                                  <?php echo empty($DataNguoiDung["MaTaiKhoan"]) || $DataNguoiDung['DoiTuong'] === "KhachHang" ? null : '  <p style="margin-top:38px" id="unravelAccount"><span style="border-radius:10px;  cursor: pointer; padding:6px; border:1px solid ; background-color:#42403d;color:#fff9f9;" onclick="unravelAccount()">Gỡ tài khoản</span></p>' ?>
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
  let unravel = document.getElementById("unravelAccount");

  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
  }

  function validatePhoneNumber(phoneNumber) {
    const re = /^\d+$/;
    return re.test(phoneNumber);
  }
  document.getElementById("submit-form").addEventListener('submit', function check(event) {
    // let matkhau = document.getElementById("matkhau");
    //  let taikhoan = document.getElementById("taikhoan");
    let HoTen = document.getElementById("HoTen");
    let sdt = document.getElementById("sdt");
    let diachi = document.getElementById("diachi");
    let gioitinh_male = document.getElementById("gioitinh_male");
    let gioitinh_female = document.getElementById("gioitinh_female");
    // let vaitro = document.getElementById("vaitro");
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
    // if (!vaitro.value.trim()) {
    //     alert("Vai trò không được để trống");
    //     vaitro.focus();
    //     flat = false;
    //     event.preventDefault();
    //     return;
    // }
    if (!email.value.trim()) {
      alert("Email không được để trống");
      email.focus();
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
    if (!validateEmail(email.value.trim())) {
      alert("Email Không hợp lệ");
      email.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    if (!ngaysinh.value.trim()) {
      alert("Ngày sinh không được để trống");
      ngaysinh.focus();
      flat = false;
      event.preventDefault();
      return;
    }
    alert("Bạn đã sửa thành công")
  });

  function unravelAccount() {
    unravel.style.display = "none";
    let select = document.getElementById("taikhoan");
    var option = document.createElement("option");
    option.text = "Chọn tài khoản";
    option.value = "";
    option.selected = true;
    select.add(option);

  }

  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
  /*function unravelAccount(){
    let id = <?php // echo $DataNguoiDung['MaNguoiDung'] 
              ?>;
    let taikhoan = document.getElementById("taikhoan")
    console.log(id);
    let link = "../ManagerController/NguoiDungController.php?page=User&action=GoTaiKhoan&id=" + id + "&TaiKhoan=" + taikhoan;
    console.log(link)
    $.ajax({
      url: link,
      type: 'GET',
      success: function(data) {
        console.log(data);
        var tempElement = $('<div>').html(data);
        var newTbody = tempElement.find('.newData').first();
        var currentTbody = $('.newData').first();
        currentTbody.replaceWith(newTbody);
      },
      error: function(xhr, status, error) {
        console.error('Error: ' + xhr.status + ' - ' + error);
      }
    });
  }
  */
</script>

</html>
