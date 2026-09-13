<?php
// session_start();
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/UTH-PHP/src/public/template/frontEnd/Manager/AdminDemo.css" />
  <link rel="stylesheet" href="/UTH-PHP/view/admin/InventoryView/adminDemo.css" />
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

                  <!-- sửa từ đây -->
                  <div class="Admin_rightBar__RXnS9">
                    <div style="
                          display: flex;
                          margin-bottom: 1rem;
                          align-items: center;
                        ">
                      <p class="Admin_title__1Tk48">Quản lí đơn hàng</p>
                    </div>
                    <div class="Admin_boxFeature__ECXnm">
                      <label for=""> Mã đơn hàng:</label>
                      <div style="position: relative">
                        <input class="Admin_input__LtEE-" type="text" />
                      </div>

                      <label for=""> Từ ngày:</label>
                      <div style="position: relative">
                        <input class="Admin_input__LtEE-" type="date" />
                      </div>

                      <label for=""> đến </label>
                      <div style="position: relative">
                        <input class="Admin_input__LtEE-" type="date" />
                      </div>

                      <label for=""> Trạng thái:</label>
                      <div style="position: relative">
                        <select class="Admin_select__LtEE-" id="orderStatus" style="height: 3rem;
                            border: 1px solid rgb(156, 155, 155);
                            width: 20rem;
                            padding: 0.5rem 1rem 0.5rem 2.5rem;
                            border-radius: 2px;">
                          <option value="">Tất cả đơn hàng</option>
                          <option value="ChoDuyet">Chờ duyệt</option>
                          <option value="DaDuyet">Đã duyệt</option>
                          <option value="DangGiao">Đang giao hàng</option>
                          <option value="GiaoThanhCong">Giao hàng thành công</option>
                          <option value="Huy">Hủy</option>
                        </select>
                      </div>
                      <button class='filter' style="
margin-left: auto;
                            font-family: Arial;
                            font-size: 1.5rem;
                            font-weight: 700;
                            color: white;
                            background-color: rgb(14, 195, 14);
                            padding: 1rem;
                            border-radius: 0.6rem;
                            cursor: pointer;
                          ">
                        xác nhận
                      </button>
                    </div>
                    <div class="Admin_boxTable__hLXRJ table-responsive">
                      <table class="table align-middle table-striped table-hover table-cell-padding-y Table_table__BWPy">
                        <thead class="Table_head__FTUog table-dark">
                          <tr>
                            <th class="Table_th__hCkcg sort2">Mã đơn</th>
                            <th class="Table_th__hCkcg sort1">Ngày đặt</th>
                            <th class="Table_th__hCkcg sort">Tổng đơn</th>
                            <th class="Table_th__hCkcg ">Mã khách</th>
                            <th class="Table_th__hCkcg">Phương thức thanh toán</th>
                            <th class="Table_th__hCkcg">Trạng thái</th>
                            <th class="Table_th__hCkcg">Hành động</th>
                          </tr>
                        </thead>
                        <tbody class="table-striped" id="table-donhang">
                          <?php
                          $printed_orders = [];
                          $order_statuses = [];
                          usort($data->data, function ($a, $b) {
                            return strtotime($b['NgayCapNhat']) - strtotime($a['NgayCapNhat']);
                          });

                          foreach ($data->data as $record) {
                            $maDonHang = $record['MaDonHang'];
                            if (in_array($maDonHang, $printed_orders)) {
                              continue;
                            }

                            // Lưu trạng thái mới nhất của mã đơn hàng
                            $order_statuses[$maDonHang] = $record['TenTrangThai'];
                            if ($order_statuses[$maDonHang] === 'ChoDuyet') {
                              $order_statuses[$maDonHang] = 'Chờ Duyệt';
                            }
                            if ($order_statuses[$maDonHang] === 'Huy') {
                              $order_statuses[$maDonHang] = 'Đã Hủy';
                            }
                            if ($order_statuses[$maDonHang] === 'DaDuyet') {
                              $order_statuses[$maDonHang] = 'Đã duyệt';
                            }
                            if ($order_statuses[$maDonHang] === 'DangGiao') {
                              $order_statuses[$maDonHang] = 'Đang Giao';
                            }
                            if ($order_statuses[$maDonHang] === 'GiaoThanhCong') {
                              $order_statuses[$maDonHang] = 'Giao Thành Công';
                            }
                            $printed_orders[] = $maDonHang;

                            echo '<tr>
                                    <td class="Table_data_quyen_1 py-4">' . $record['MaDonHang'] . '</td>
                                    <td class="Table_data_quyen_1">' . $record['NgayDat'] . '</td>
                                    <td class="Table_data_quyen_1">' . number_format($record['TongGiaTri'], 0, ',', '.') . ' đ</td>
                                    <td class="Table_data_quyen_1">' . $record['MaKH'] . '</td>
                                    <td class="Table_data_quyen_1">' . $record['TenPhuongThuc'] . '</td>
                                    <td class="Table_data_quyen_1" id="status">' . $order_statuses[$maDonHang] . '</td>';

                            if ($order_statuses[$maDonHang] == 'Chờ Duyệt' || $order_statuses[$maDonHang] == 'Đã duyệt') {
                              echo '<td class="Table_data_quyen_1"><a href="http://localhost/UTH-PHP/src/controller/cartControll/ManagerDetailDonHangController.php?maDonHang=' . $record['MaDonHang'] . '"> chi tiết</a> <button class="cancel_donhang"> hủy</button> </td>';
                            } else {
                              echo '<td class="Table_data_quyen_1"><a href="http://localhost/UTH-PHP/src/controller/cartControll/ManagerDetailDonHangController.php?maDonHang=' . $record['MaDonHang'] . '"> chi tiết</a> </td>';
                            }
                          }
                          ?>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      // Bắt sự kiện click vào class cancel_donhang
      $('#table-donhang').on("click", ".cancel_donhang", function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của nút button
        if ($(this).closest('tr').find('.Table_data_quyen_2:first').text())
          orderId = $(this).closest('tr').find('.Table_data_quyen_2:first').text();
        else
          orderId = $(this).closest('tr').find('.Table_data_quyen_1:first').text();

        var TrangThai = $(this).closest('tr').find('#status').text();
        console.log(TrangThai)
        Swal.fire({
          title: 'Xác nhận hủy đơn hàng?',
          text: "Bạn có chắc chắn muốn hủy đơn hàng này không?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Hủy',
          confirmButtonText: 'Xác nhận',
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'POST',
              url: 'http://localhost/UTH-PHP/src/controller/cartControll/cartController.php',
              data: {
                maDonHang: orderId,
                TrangThai: TrangThai,
                action: 'huyDonHang'
              },

              success: function(response) {
                console.log(TrangThai);
                // Hiển thị thông báo hủy thành công
                Swal.fire({
                  title: 'Hủy thành công!',
                  text: 'Đơn hàng đã được hủy.',
                  icon: 'success',
                }).then(() => {
                  // Cập nhật trạng thái của đơn hàng trong DOM
                  // $(this).closest('tr').find('.Table_data_quyen_1:first').text('Đã Hủy');
                  location.reload();

                });
              },
              error: function(xhr, status, error) {
                // Xử lý lỗi nếu có
                console.error(error);
              }
            });
          }
        });
      });
    });


    $(document).ready(function() {
      $('.filter').on('click', function() {
        var maDonHang = $('input[type="text"]').val();
        var tuNgay = $('input[type="date"]').eq(0).val();
        var denNgay = $('input[type="date"]').eq(1).val();
        var trangThai = $('#orderStatus').val();
        console.log(maDonHang, tuNgay, denNgay, trangThai)

        // Gửi AJAX request để lấy dữ liệu mới dựa trên các tham số lọc
        $.ajax({
          url: 'http://localhost/UTH-PHP/src/controller/cartControll/filterOrder.php',
          method: 'POST',
          data: {
            maDonHang: maDonHang,
            tuNgay: tuNgay,
            denNgay: denNgay,
            trangThai: trangThai
          },
          success: function(response) {
            $('.Admin_boxTable__hLXRJ tbody').html(response);
            console.log(response)
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });

    });
    $(document).ready(function() {
      var ascending = true;

      $('.sort').click(function() {
        ascending = !ascending;

        var rows = $('.Admin_boxTable__hLXRJ tbody tr').get();

        rows.sort(function(row1, row2) {
          var value1 = parseFloat($(row1).find('.Table_data_quyen_1:nth-child(3)').text().replace(' đ', '').replace(/\./g, ''));
          var value2 = parseFloat($(row2).find('.Table_data_quyen_1:nth-child(3)').text().replace(' đ', '').replace(/\./g, ''));

          if (ascending) {
            return value1 - value2;
          } else {
            return value2 - value1;
          }
        });
        $('.Admin_boxTable__hLXRJ tbody').empty();
        $.each(rows, function(index, row) {
          $('.Admin_boxTable__hLXRJ tbody').append(row);
        });
      });
    });

    $(document).ready(function() {
      var ascending = true;

      $('.sort1').click(function() {

        ascending = !ascending;

        var rows = $('.Admin_boxTable__hLXRJ tbody tr').get();

        rows.sort(function(row1, row2) {
          var value1 = new Date($(row1).find('.Table_data_quyen_1:nth-child(2)').text());
          var value2 = new Date($(row2).find('.Table_data_quyen_1:nth-child(2)').text());

          if (ascending) {
            return value1 - value2;
          } else {
            return value2 - value1;
          }
        });
        $('.Admin_boxTable__hLXRJ tbody').empty();

        $.each(rows, function(index, row) {
          $('.Admin_boxTable__hLXRJ tbody').append(row);
        });
      });
    });
    $(document).ready(function() {
      var ascending = true;
      $('.sort2').click(function() {
        ascending = !ascending;

        var rows = $('.Admin_boxTable__hLXRJ tbody tr').get();

        rows.sort(function(row1, row2) {
          var value1 = parseInt($(row1).find('.Table_data_quyen_1:nth-child(1)').text());
          var value2 = parseInt($(row2).find('.Table_data_quyen_1:nth-child(1)').text());

          if (ascending) {
            return value1 - value2;
          } else {
            return value2 - value1;
          }
        });

        $('.Admin_boxTable__hLXRJ tbody').empty();

        $.each(rows, function(index, row) {
          $('.Admin_boxTable__hLXRJ tbody').append(row);
        });
      });
    });
    document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
      // Redirect to the desired page
      window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
