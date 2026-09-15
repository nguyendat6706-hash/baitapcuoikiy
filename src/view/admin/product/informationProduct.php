<?php
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang'])) {
  // Nếu không có, chuyển hướng đến trang khác
  header("Location: http://localhost/UTH-PHP/src/controller/HomeController/HomeController.php");
  exit; // Đảm bảo dừng kịp thời việc thực thi của script
}

function checkFeatureExists($featureID) {
  // Kiểm tra xem $featureID có tồn tại trong mảng $_SESSION['chucNang'] không
  return in_array($featureID, $_SESSION['chucNang']);
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-j6ud1PvOBhgFjlY0W46HwjOeZl3Ni6N4+BCzpu8K3RCDZs/T4pbFpoZYy4CkeiN1" crossorigin="anonymous">
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/informationProduct.css">
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
                <div class="Sidebar_sideBar__CC4MK" style="margin-top: 10px;">
                  <?php
                  echo loadPageDependOnFeature();
                  ?>
                </div>
                <div style="padding-left: 16%; width: 100%; padding-right: 2rem;margin-top: 10px;">
                  <div class="wrapper">
                    <div style="
                          display: flex;
                          padding-top: 1rem;
                          padding-bottom: 1rem;
                        ">
                      <h2>Sản Phẩm</h2>

                      <?php
                      if (checkFeatureExists(7)) {
                        echo '<button class="btn__taoSanPham" style="
            margin-left: auto;
            font-family: Arial;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            background-color: rgb(65, 64, 64);
            padding: 1rem;
            border-radius: 0.6rem;
            cursor: pointer;
          ">
          Tạo Sản Phẩm
        </button>';
                      }
                      ?>
                    </div>
                    <div class="boxFeature">
                      <div style="position: relative">
                        <span class="icon"></span>
                        <input id="searchInput" class="input" placeholder="Tìm kiếm sản phẩm" />
                      </div>

                      <select class="filter__nongDoCon" style="height: 3rem; padding: 0.3rem">
                        <option value="default" selected>Nồng Độ Cồn</option>
                        <option value="0-20%">Dưới 20%</option>
                        <option value="20-40%">20%-40%</option>
                        <option value="40-60%">40%-60%</option>
                        <option value="above-60%">Trên 60%</option>
                      </select>

                      <select class="filter__theTich" style="height: 3rem; padding: 0.3rem">
                        <option value="default" selected>Dung Tích</option>
                        <option value="below-500ml">Dưới 500ml</option>
                        <option value="below-750ml">Dưới 750ml</option>
                        <option value="below-1000ml">Dưới 1000ml</option>
                        <option value="below-4500ml">Dưới 4500ml</option>
                      </select>

                      <select class="filter__price" style="height: 3rem; padding: 0.3rem">
                        <option value="default" selected>Mức giá</option>
                        <option value="0-100">Từ 0 đến 100 nghìn</option>
                        <option value="100-500">Từ 100 nghìn đến 500 nghìn</option>
                        <option value="500-1000">Từ 500 nghìn đến 1 triệu</option>
                        <option value="1000-2000">Từ 1 triệu đến 2 triệu</option>
                        <option value="2000-5000">Từ 2 triệu đến 5 triệu</option>
                        <option value="5000-8000">Từ 5 triệu đến 8 triệu</option>
                        <option value="8000-10000">Từ 8 triệu đến 10 triệu</option>
                        <option value="10000-13000">Từ 10 triệu đến 13 triệu</option>
                        <option value="13000-18000">Từ 13 triệu đến 18 triệu</option>
                        <option value="18000-25000">Từ 18 triệu đến 25 triệu</option>
                        <option value="above-25000">Trên 25 triệu</option>
                      </select>
                      <div class="paginationFilter" style="margin-left: auto">
                        <div>
                          <button class="prev"><i class="fa-solid fa-angles-left"></i></button>
                        </div>
                        <span class="valuePage">1</span>
                        <div>
                          <button class="next"><i class="fa-solid fa-angles-right"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="boxTable">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th id="sortIdAsc" style="width: 70px;cursor: pointer;">ID <i class="fa-solid fa-caret-down"></th>
                            <th>Hình Ảnh</th>
                            <th id="sortNameAsc" style="cursor: pointer;">Tên Sản Phẩm <i class="fa-solid fa-caret-down"></th>
                            <th>Thuong Hieu</th>
                            <th id="sortPrice" style="cursor: pointer;width: 100px;">Giá Tiền <i class="fa-solid fa-caret-down"></th>
                            <th id="sortNongDo" style="width: 100px;cursor: pointer;">Nồng Độ <i class="fa-solid fa-caret-down"></th>
                            <th id="sortDungTich" style="width: 100px;cursor: pointer;">Dung Tích <i class="fa-solid fa-caret-down"></th>
                            <th style="width: 90px;">Xuất Xứ</th>
                            <th id="sortSoLuongConLai" style="width: 100px;cursor: pointer;">Số Lượng <i class="fa-solid fa-caret-down"></th>
                            <th id="sortTrangThai" style="width: 145px;">Trạng thái</th>
                            <th style="width: 300px;">Thao Tác</th>
                          </tr>
                        </thead>
                        <tbody class="tableProduct">

                          <?php
                          foreach ($data->data as $product) {
                            $statusClass = ($product['TrangThai'] == 1) ? 'btn-lock' : 'btn-open'; // Class "btn-lock" cho trạng thái 1, class "btn-open" cho trạng thái 0

                            // Thiết lập văn bản của nút tùy thuộc vào giá trị của TrangThai
                            $activeButtonText = ($product['TrangThai'] == 1) ? 'Khóa' : 'Mở';
                            $activeText = ($product['TrangThai'] == 1) ? 'Đang hoạt động' : 'Đang khóa';
                            echo "<tr style=\"text-align: center\">
            <td>{$product['MaSanPham']}</td>
            <td><img src=\"{$product['AnhMinhHoa']}\" alt=\"{$product['TenSanPham']}\"></td>
            <td>{$product['TenSanPham']}</td>
            <td>{$product['ThuongHieu']}</td>
            <td>{$product['Gia']}</td>
            <td>{$product['NongDoCon']}%</td>
            <td>{$product['TheTich']}ml</td>
            <td>{$product['XuatXu']}</td>
            <td>{$product['SoLuongConLai']}</td>
            <td>{$activeText}</td>
            <td>";
                            if (checkFeatureExists(7)) {
                              echo "<button class=\"editProduct\" data-maSanPham=\"{$product['MaSanPham']}\">sửa</button>";
                            }
                            if (checkFeatureExists(8)) {
                              echo "<button class=\"setStatus $statusClass\" data-maSanPham=\"{$product['MaSanPham']}\">$activeButtonText</button>  
            ";
                            }
                            echo "</td>
          </tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                      <div class="textMessage" style="text-align: center;">
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/UTH-PHP/src/view/assets/js/managerProduct/script.js"></script>
</body>

</html>
