<?php

// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(21, $_SESSION['chucNang'])) {

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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <link rel="stylesheet" href="/UTH-PHP/src/public/template/frontEnd/Manager/AdminDemo.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/detail_donhang/detail_donhang.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/admin/managerDonHang/qldonhang.css" />
  <title>Document</title>
</head>

<body>
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
                  <div class="orderManagement_order_history">
                    <div class="detail__wrapper">
                      <p class="title">Chi tiết đơn hàng: <span id="orderID"><?php echo $data->data[0]['MaDonHang'] ?></span></p>



                      <ul class="order_status__wrapper">
                        <?php
                        if ($data->data[0]['TenTrangThai'] == 'Huy') {
                          echo "  <div class='order_status completed'>
                                                                <li>Đã đặt hàng</li>
                                                            </div>
                                                            <div class='order_status completed'>
                                                                <li>Đã hủy</li>
                                                            </div>";
                        } else {
                          echo "<div class='order_status completed'>
                                                                <li>Đã đặt hàng</li>
                                                            </div>
                                                            <div class='order_status ";
                          echo ($data->data[0]['TenTrangThai'] == 'DaDuyet' || $data->data[0]['TenTrangThai'] == 'DangGiao' || $data->data[0]['TenTrangThai'] == 'GiaoThanhCong') ? 'completed' : '';
                          echo "'>
                                                                <li>Đã xác nhận</li>
                                                            </div>
                                                            <div class='order_status ";
                          echo ($data->data[0]['TenTrangThai'] == 'DangGiao' || $data->data[0]['TenTrangThai'] == 'GiaoThanhCong') ? 'completed' : '';
                          echo "'>
                                                            <li>Đang giao hàng</li>
                                                        </div>
                                                        <div class='order_status ";
                          echo ($data->data[0]['TenTrangThai'] == 'GiaoThanhCong') ? 'completed' : '';
                          echo "'>
                                                                <li>Giao hàng thành công</li>
                                                            </div>";
                        }
                        ?>


                      </ul>
                      <div class="transaction_info__wrapper">
                        <div class="receive_info__wrapper">
                          <p class="title">Thông tin người nhận:</p>
                          <div class="divider"></div>
                          <div class="receive_info">
                            <p class="name"><span>Tên: </span><?php echo $data->data[0]['HoTen'] ?></p>
                            <p><span>Địa chỉ: </span><?php echo $data->data[0]['DiaChiGiaoHang'] ?></p>
                            <p><span>Số điện thoại: </span><?php echo $data->data[0]['SoDienThoai'] ?></p>
                          </div>
                        </div>

                        <div class="payment_method__wrapper">
                          <p class="title">Phương thức thanh toán:</p>
                          <div class="divider"></div>
                          <p><?php echo $data->data[0]['TenPhuongThuc'] ?><br>
                            <!-- <span> CHỈ ÁP DỤNG TIỀN MẶT ĐỐI VỚI NỘI THÀNH TPHCM</span> -->
                          </p>
                        </div>
                        <div class="payment_method__wrapper">
                          <p class="title">Phương thức vận chuyển:</p>
                          <div class="divider"></div>
                          <p><?php echo $data->data[0]['TenDichVu'] ?><br>
                            <!-- <span> CHỈ ÁP DỤNG TIỀN MẶT ĐỐI VỚI NỘI THÀNH TPHCM</span> -->
                          </p>
                        </div>
                      </div>

                      <div class="transaction_items__wrapper">
                        <!-- <p class="transaction_name">Trạng thái:
                                                    <span class=""><?php
                                                                    if ($data->data[0]['TenTrangThai'] == 'ChoDuyet') {
                                                                      $data->data[0]['TenTrangThai'] = 'Chờ xác nhận';
                                                                    }
                                                                    if ($data->data[0]['TenTrangThai'] == 'DaDuyet') {
                                                                      $data->data[0]['TenTrangThai'] = 'Đã xác nhận';
                                                                    }
                                                                    if ($data->data[0]['TenTrangThai'] == 'DangGiao') {
                                                                      $data->data[0]['TenTrangThai'] = 'Đang giao hàng';
                                                                    }
                                                                    if ($data->data[0]['TenTrangThai'] == 'GiaoThanhCong') {
                                                                      $data->data[0]['TenTrangThai'] = 'Đã giao hàng';
                                                                    }
                                                                    echo $data->data[0]['TenTrangThai'] ?></span>
                                                </p> -->
                        <div class="divider"></div>
                        <div class="transaction_list">

                          <?php
                          $uniqueProducts = [];
                          foreach ($data->data as $donhang) {
                            $productId = $donhang['MaSanPham'];
                            if (!array_key_exists($productId, $uniqueProducts)) {
                              $uniqueProducts[$productId] = $donhang;
                            }
                          }

                          // Hiển thị các sản phẩm duy nhất
                          foreach ($uniqueProducts as $donhang) {
                            echo "
                                                            <div class='transaction_item'><img  src='{$donhang['AnhMinhHoa']}' alt=''>
                                                                <div class='item_info__wrapper'>
                                                                    <div class='item_info'>
                                                                        <p class='name'>{$donhang['TenSanPham']}</p>
                                                                    </div>
                                                                    <div class='item_info'>
                                                                        <p class='quantity'>X{$donhang['SoLuong']}</p>
                                                                        <p class='price'>" . number_format($donhang['Gia'], 0, ',', '.') . "&nbsp;đ</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='divider'></div>";
                          }
                          ?>
                          <div class='divider'></div>
                        </div>
                        <div class='divider'></div>
                      </div>
                      <div class="order_total__wrapper">
                        <!-- <div>
                                                    <p>Tổng tạm tính:</p>
                                                    <p>1.070.000&nbsp;đ</p>
                                                </div>
                                                <div>
                                                    <p>Giảm giá:</p>
                                                    <p>0 đ</p>
                                                </div>
                                                <div>
                                                    <p>Phí vận chuyển:</p>25.000 đ
                                                </div> -->
                        <div class="total">
                          <p>Thành tiền:</p>
                          <p id="totalPrice"><?php echo  number_format($data->data[0]['TongGiaTri'], 0, ',', '.') ?>&nbsp;đ</p>
                        </div>
                      </div>
                    </div>


                  </div>

                </div>
                <!-- đến đây -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      $('.order_status').on('click', function() {
        var clickedIndex = $(this).index();

        if ($(this).hasClass('completed')) {
          Swal.fire({
            icon: 'info',
            text: 'Trạng thái này đã được cập nhật trước đó.'
          });
          return;
        }

        if (clickedIndex === 2) {
          console.log('clickedIndex: ', clickedIndex);
          if (!$('.order_status:eq(1)').hasClass('completed')) {
            Swal.fire({
              icon: 'error',
              text: 'Hãy duyệt đơn trước khi giao hàng.'
            });
            return;
          }
        }
        if (clickedIndex === 3) {
          console.log('clickedIndex: ', clickedIndex);
          if (!$('.order_status:eq(2)').hasClass('completed')) {
            Swal.fire({
              icon: 'error',
              text: 'Hãy duyệt đang giao trước khi duyệt nhận hàng.'
            });
            return;
          }
        }

        var orderId = $('#orderID').text();
        console.log('orderId: ', orderId);

        $.ajax({
          url: 'http://localhost/UTH-PHP/src/controller/cartControll/cartController.php',
          method: 'POST',
          data: {
            orderId: orderId,
            clickedIndex: clickedIndex,
            action: 'update_status',
          },
          success: function(response) {
            console.log('response: ', response);

            // Parse JSON response
            var result = JSON.parse(response);
            if (result.result) {
              $('.order_status').eq(clickedIndex).addClass('completed');
              Swal.fire({
                icon: 'success',
                text: 'Cập nhật trạng thái thành công.'
              });
            } else {
              Swal.fire({
                icon: 'error',
                text: 'vui lòng nhập thêm sản phẩm vào kho.'
              });
            }
          },
          error: function(xhr, status, error) {
            console.error(error);
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
