<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/CartModel/DonHang.php";
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";

require_once "$projectRoot/src/model/CartModel/TrangThaiDonHang.php";

$donhang = new DonHang();
session_start();
if (!isset($_SESSION['MaTaiKhoan'])) {
  header('Location: /UTH-PHP/src/controller/AccountController/AccountController.php');
} else {
  $maTaiKhoan = $_SESSION['MaTaiKhoan'];
}
$data = $donhang->getDonHang($maTaiKhoan);
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/xemlaidonhang/ctdonhang.css" />
  <title>Document</title>
</head>

<body>

  <?php
  $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
  require_once "$projectRoot/src/view/include/header.php"
  ?>

  <div class="container container_profile containerPage" style="margin: 0;margin-top:70px">
    <?php
    $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
    require_once "$projectRoot/src/view/include/headerThongTinUser.php";
    ?>

    <div class="orderManagement_order_history">
      <?php
      $numberOfProducts = count(array_unique(array_column($data->data, 'MaDonHang')));
      if ($numberOfProducts > 0) {
        echo " <p class='orderManagement_title'>Đơn hàng của bạn</p>";
      } else {
        echo "<p class='emty_cart' style='margin: 150px 0 200px;
                    display: flex;
                    justify-content: center;'>Bạn chưa có đơn hàng nào!</p>";
      }
      ?>


      <?php
      $invoices = array();
      $order_statuses = [];


      foreach ($data->data as $donhang) {
        $MaDonHang = $donhang['MaDonHang'];

        $tenTrangThaiArray = explode(',', $donhang['TenTrangThai']);
        $lastTenTrangThai = end($tenTrangThaiArray);
        if (!isset($invoices[$MaDonHang])) {
          $invoices[$MaDonHang] = array(
            'MaDonHang' => $MaDonHang,
            'TongCong' => 0,
            'SanPham' => array(),
            'TenTrangThai' => $lastTenTrangThai
          );
        }

        // Kiểm tra xem sản phẩm đã tồn tại trong đơn hàng chưa
        $found = false;
        foreach ($invoices[$MaDonHang]['SanPham'] as $sanPham) {
          if ($sanPham['TenSanPham'] == $donhang['TenSanPham']) {
            $found = true;
            break;
          }
        }

        if (!$found) {
          $SanPham = array(
            'TenSanPham' => $donhang['TenSanPham'],
            'Gia' => $donhang['Gia'],
            'SoLuong' => $donhang['SoLuong'],
            'AnhMinhHoa' => $donhang['AnhMinhHoa']
          );

          $invoices[$MaDonHang]['TongCong'] += $donhang['ThanhTien'];
          $invoices[$MaDonHang]['SanPham'][] = $SanPham;
        }
      }

      foreach ($invoices as $hoaDon) {
        $class = '';
        if ($hoaDon['TenTrangThai'] == "ChoDuyet") {
          $hoaDon['TenTrangThai'] = 'Chờ xác nhận';
          $class = 'order-status-blue';
        }
        if ($hoaDon['TenTrangThai'] == "Huy") {
          $hoaDon['TenTrangThai'] = 'Đã hủy';
          $class = 'order-status-red';
        }
        if ($hoaDon['TenTrangThai'] == "DaDuyet") {
          $hoaDon['TenTrangThai'] = 'Đã xác nhận';
          $class = 'order-status-blue';
        }
        if ($hoaDon['TenTrangThai'] == "DangGiao") {
          $hoaDon['TenTrangThai'] = 'Đang giao hàng';
          $class = 'order-status-blue';
        }
        if ($hoaDon['TenTrangThai'] == "GiaoThanhCong") {
          $hoaDon['TenTrangThai'] = 'Đã nhận hàng';
          $class = 'order-status-green';
        }


        echo "<div class='orderManagement_order_list'>
        <div class='orderManagement_order__wrapper'>
            <div class='orderManagement_title__wrapper'>
                <p class='orderManagement_title'>
                    Mã đơn hàng: <span class='maDonHang'>{$hoaDon['MaDonHang']}</span> 
                    <span>|</span>
                    <span id='trangthai' class='{$class}'> {$hoaDon['TenTrangThai']}</span>
                </p>
                <a href='/UTH-PHP/src/controller/cartControll/DetailDonHangForUserController.php/?maDonHang={$hoaDon['MaDonHang']}' class='orderManagement_detail__button'>
                    <p class='orderManagement_mobile_hidden'>Chi tiết</p>
                </a>
            </div>";




        foreach ($hoaDon['SanPham'] as $sanPham) {
          $price = number_format($sanPham['Gia'], 0, ',', '.');
          echo "<div class='orderManagement_divider'></div>
        <div class='orderManagement_item_list__wrapper'>
            <div class='orderManagement_item__wrapper'>
                <div class='orderManagement_item'>
                    <img class=' ' src='{$sanPham['AnhMinhHoa']}' alt='thumbnail' />
                    <div class='orderManagement_item_info__wrapper'>
                        <div class='orderManagement_item_info'>
                            {$sanPham['TenSanPham']}
                        </div>
                        <div class='orderManagement_item_info'>
                            <span class='orderManagement_quantity'>X{$sanPham['SoLuong']}</span>
                            <span>{$price}&nbsp;đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
        }

        $totalPrice = number_format($hoaDon['TongCong'], 0, ',', '.');
        if ($hoaDon['TenTrangThai'] === 'Chờ xác nhận' || $hoaDon['TenTrangThai'] === 'Đã xác nhận') {
          echo "
            <div class='orderManagement_divider'></div>
            <div class='orderManagement_cancel'>
                <div class='orderManagement_total'>
                    Tổng cộng: <span>{$totalPrice}&nbsp;đ</span>
                </div>
                <button class='cancel_donhang'>Hủy đơn hàng</button>
            </div>
        </div>
    </div>
    ";
        } elseif ($hoaDon['TenTrangThai'] === 'Đang giao hàng') {
          echo "
            <div class='orderManagement_divider'></div>
            <div class='orderManagement_cancel'>
                <div class='orderManagement_total'>
                    Tổng cộng: <span>{$totalPrice}&nbsp;đ</span>
                </div>
                <button class='received_donhang'>Đã nhận được hàng</button>
            </div>
        </div>
    </div>";
        } else {
          echo "
            <div class='orderManagement_divider'></div>
            <div p class='orderManagement_cancel'>
                <div class='orderManagement_total'>
                    Tổng cộng: <span>{$totalPrice}&nbsp;đ</span>
                </div>
            </div>
        </div>
    </div>";
        }
      }
      ?>
    </div>

  </div>

  <?php
  require_once "$projectRoot/src/view/include/footer.php"
  ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    function showSuccessMessage(message) {
      Swal.fire({
        icon: 'success',
        // title: 'Success!',
        text: message,
        timer: 1000,
        // timerProgressBar: false,
        // showConfirmButton: false
      });
    }




    $(document).ready(function() {
      $('.cancel_donhang').on('click', function() {
        var maDonHangElement = $(this).closest('.orderManagement_order_list').find('.maDonHang');
        var maDonHang = maDonHangElement.text().trim();
        console.log(maDonHang);
        var button = $(this);

        $.ajax({
          url: '/UTH-PHP/src/controller/cartControll/cartController.php',
          method: 'POST',
          data: {
            maDonHang: maDonHang,
            action: 'huyDonHang'
          },
          success: function(response) {
            console.log(response);
            Swal.fire({
              title: 'Xác nhận hủy!',
              text: 'Bạn đã xác nhận hủy.',
              icon: 'warning',
            }).then((result) => {
              if (result.isConfirmed) {
                // button.hide();
                // button.load();
                var newTitleHTML = "<p class='orderManagement_title'>Mã đơn hàng: <span class='maDonHang'>" + maDonHang + "</span><span>|</span><span id='trangthai' class='order-status-red'>Đã hủy</span></p> <a href='/UTH-PHP/src/controller/cartControll/DetailDonHangForUserController.php/?maDonHang={$hoaDon['MaDonHang']}' class='orderManagement_detail__button'> <p class = 'orderManagement_mobile_hidden' > Chi tiết </a>";

                // Thay thế HTML cũ bằng HTML mới
                $('.orderManagement_title__wrapper').html(newTitleHTML);
                // button.load();
                window.location.reload();
              }
            });
          }
        });
      });
    });






    $(document).ready(function() {
      $('.received_donhang').on('click', function() {
        var maDonHangElement = $(this).closest('.orderManagement_order_list').find('.maDonHang');
        var maDonHang = maDonHangElement.text().trim();
        var button = $(this);

        $.ajax({
          url: '/UTH-PHP/src/controller/cartControll/cartController.php',
          method: 'POST',
          data: {
            maDonHang: maDonHang,
            action: 'received'
          },
          success: function(response) {
            console.log(response);
            Swal.fire({
              title: 'Nhận hàng thành công!',
              text: 'Bạn đã xác nhận nhận hàng thành công.',
              icon: 'success'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });
  </script>
</body>