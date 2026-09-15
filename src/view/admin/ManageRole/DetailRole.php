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
  <link rel="stylesheet" href="./../../view/assets/css/DetailRole.css" />
  <link rel="stylesheet" href="./../../view/assets/css/oneForAll.css" />
  <link rel="stylesheet" href="./../../view/assets/css/Admin.css" />
  <link rel="stylesheet" href="./../../view/assets/css/temp.css" />
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
                    <div style="display: flex; margin-bottom: 1rem; align-items: center;">
                      <p class="Admin_title__1Tk48">Thêm phân quyền</p>
                    </div>
                    <form action="../AdminController/AdminIndex.php" id="submit_Form" method="post">

                      <div class="addNhomQuyen">
                        <input type="hidden" name="action" value="add_Role">
                        <div id="error_notice"></div>
                        <input id="nameQuyen" type="text" onchange="checkTenQuyen()" name="TenNhomQuyen" placeholder="Thêm nhóm quyền">
                        <a id="huy" style="margin-left:35%" href="../AdminController/AdminIndex.php?page=Role">Hủy</a>
                        <button id="cap_nhat">Cập nhật</button>
                        <div id="authic"></div>
                      </div>
                      <div class="phanquyen-table-wrap">
                        <table class="Phanquyen-feature">
                          <tr class="phanQuyen-head">
                            <th class="phanQuyen">Chức năng </th>
                            <th class="phanQuyen">Xem</th>
                            <th class="phanQuyen">Thêm </th>
                            <th class="phanQuyen">Sửa</th>
                            <th class="phanQuyen">Xóa</th>
                            <th class="phanQuyen">Khóa/ Mở Khóa</th>
                          </tr>
                          <tr class="Table-row-chan">
                            <td class="phanquyen-value">Quản lý Quyền</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyQuyen[]" value="27"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyQuyen[]" value="28"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyQuyen[]" value="29"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyQuyen[]" value="30"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                          </tr>
                          <tr class="Table-row-le">
                            <td class="phanquyen-value">Quản lý Tài khoản</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyTaiKhoan[]" value="2"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyTaiKhoan[]" value="3"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyTaiKhoan[]" value="4"></td>

                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyTaiKhoan[]" value="5"></td>
                          </tr>
                          <tr class="Table-row-chan">
                            <td class="phanquyen-value">Quản lý sản phẩm</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLySanPham[]" value="6"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLySanPham[]" value="7"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLySanPham[]" value="8"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLySanPham[]" value="9"></td>
                          </tr>
                          <tr class="Table-row-le">
                            <td class="phanquyen-value">Quản lý loại sản phẩm</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyLoaiSanPham[]" value="10"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyLoaiSanPham[]" value="11"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyLoaiSanPham[]" value="12"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyLoaiSanPham[]" value="13"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                          </tr>
                          <tr class="Table-row-chan">
                            <td class="phanquyen-value">Quản lý nhà cung cấp</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNhaCungCap[]" value="14"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNhaCungCap[]" value="15"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNhaCungCap[]" value="16"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNhaCungCap[]" value="17"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                          </tr>

                          <tr class="Table-row-le">
                            <td class="phanquyen-value">Phiếu nhập kho</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyPhieuNhapKho[]" value="18"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyPhieuNhapKho[]" value="19"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>

                          </tr>
                          <tr class="Table-row-chan">
                            <td class="phanquyen-value">Quản lý đơn hàng</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyDonHang[]" value="21"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyDonHang[]" value="22"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>


                          </tr>

                          <tr class="Table-row-le">
                            <td class="phanquyen-value">Quản lý Người dùng</td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNguoiDung[]" value="23"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNguoiDung[]" value="24"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNguoiDung[]" value="25"></td>
                            <td class="phanquyen-value"><input type="checkbox" name="QuanLyNguoiDung[]" value="26"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                          </tr>
                          <tr class="Table-row-chan">
                            <td class="phanquyen-value">Thống kê tổng quát</td>
                            <td class="phanquyen-value"><input type="checkbox" name="ThongKe[]" value="31"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>
                          </tr>
                          <tr class="Table-row-le">
                            <td class="phanquyen-value">Thống kê đơn hàng</td>
                            <td class="phanquyen-value"><input type="checkbox" name="ThongKe[]" value="32"></td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>
                            <td class="phanquyen-value" style="color:red">x</td>
                          </tr>
                        </table>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function checkTenQuyen() {
      let search = document.getElementById("nameQuyen");
      let searchValue = search ? search.value : "";
      let link = ""
      if (search) {
        link = "../AdminController/AdminIndex.php?page=Role&action=KiemTraRole&search=" + searchValue;
      }

      console.log(link);
      $.ajax({
        url: link,
        type: 'GET',
        success: function(data) {
          document.getElementById("authic").innerHTML = data;
          console.log(data);
        },
        error: function(xhr, status, error) {
          console.error('Error: ' + xhr.status + ' - ' + error);
        }
      });
    }

    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const capNhatButton = document.getElementById('submit_Form');


    document.addEventListener("DOMContentLoaded", function() {
      //  console.log( document.getElementById("thongbao").textContent);
      const checkboxes = document.querySelectorAll('input[type="checkbox"]');
      const form = document.getElementById('submit_Form'); // Thay đổi ID thành 'submit_Form'

      form.addEventListener('submit', function(event) {
        let chonItNhatMotCheckbox = false;

        checkboxes.forEach(checkbox => {
          if (checkbox.checked) {
            chonItNhatMotCheckbox = true;
          }
        });

        if (!chonItNhatMotCheckbox) {
          alert("Bạn phải chọn ít nhất 1 chức năng");
          event.preventDefault();
          return;
        }

        const TenQuyen = document.getElementById("nameQuyen").value.trim();
        if (TenQuyen === "") {
          alert("Tên Nhóm Quyền Không được để trống");
          event.preventDefault();
          return;
        }
        console.log(document.getElementById("thongbao").textContent);
        if (document.getElementById("thongbao").textContent !== "Tên Quyền có thể sử dụng") {
          alert("Tên Nhóm Quyền đã tồn tại");
          event.preventDefault();
          return;
        }

        // Các phần chức năng khác đã được bỏ qua
      });
    });

    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyTaiKhoan[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '3' || this.value === '4' || this.value === '5')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyTaiKhoan[]"][value="2"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }

          } else if (!this.checked && this.value === '2') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyTaiKhoan[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '2') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyQuyen[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '28' || this.value === '29' || this.value === '30')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyQuyen[]"][value="27"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '27') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyQuyen[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '27') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLySanPham[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '7' || this.value === '8' || this.value === '9')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLySanPham[]"][value="6"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '6') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLySanPham[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '6') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyLoaiSanPham[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '11' || this.value === '12' || this.value === '13')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyLoaiSanPham[]"][value="10 "]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '10') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyLoaiSanPham[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '10') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyLoaiSanPham[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '11' || this.value === '12' || this.value === '13')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyLoaiSanPham[]"][value="10"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '10') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyLoaiSanPham[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '10') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyNhaCungCap[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '15' || this.value === '16' || this.value === '17')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyNhaCungCap[]"][value="14"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '14') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyNhaCungCap[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '14') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyPhieuNhapKho[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '20' || this.value === '19')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyPhieuNhapKho[]"][value="18"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '18') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyPhieuNhapKho[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '18') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyDonHang[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '22')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyDonHang[]"][value="21"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '21') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyDonHang[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '21') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.addEventListener("DOMContentLoaded", function() {
      // Lấy tất cả các checkbox có name là "QuanLyTaiKhoan[]"
      var checkboxes = document.querySelectorAll('input[name="QuanLyNguoiDung[]"]');
      let i = 0;
      // Sự kiện change cho từng checkbox
      checkboxes.forEach(function(checkbox) {
        i += 1;
        console.log(i);
        checkbox.addEventListener('change', function() {
          console.log("đã tick");
          // Nếu checkbox được tích và có value là 3, 4 hoặc 5
          if (this.checked && (this.value === '24' || this.value === '25' || this.value === '26')) {
            // Kiểm tra nếu checkbox value 2 chưa được tích
            var checkbox2 = document.querySelector('input[name="QuanLyNguoiDung[]"][value="23"]');
            if (checkbox2 && !checkbox2.checked) {
              checkbox2.checked = true; // Tích checkbox value 2
            }
          } else if (!this.checked && this.value === '23') {
            // Nếu checkbox value 2 bị gỡ tích, gỡ tích tất cả các checkbox khác
            var checkboxes = document.querySelectorAll('input[name="QuanLyNguoiDung[]"]');
            checkboxes.forEach(function(item) {
              if (item.value !== '23') {
                item.checked = false;
              }
            });
          }
        });
      });


    });
    document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
      // Redirect to the desired page
      window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
    });
  </script>
</body>

</html>
