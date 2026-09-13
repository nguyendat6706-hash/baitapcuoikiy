<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/detail_donhang/detail_donhang.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/xemlaidonhang/ctdonhang.css" />
  <title>Document</title>
</head>

<body>
  <?php
  $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
  // require "$projectRoot/src/view/include/header.php";
  ?>
  <header class="header">
    <div class="header__container">
      <div class="header__row v-center">
        <div class="header-item item-left">
          <div class="logo">
            <a href="/UTH-PHP/src/controller/HomeController/HomeController.php">WINE SHOP</a>
          </div>
        </div>

        <!-- menu start here -->
        <div class="header-item item-center">
          <div class="menu-overlay">
          </div>
          <nav class="menu">
            <div class="mobile-menu-head">
              <div class="go-back"><i class="fa fa-angle-left"></i></div>
              <div class="current-menu-title"></div>
              <div class="mobile-menu-close">&times;</div>
            </div>
            <ul class="menu-main">
              <li>
                <a href="/UTH-PHP/src/controller/HomeController/HomeController.php">Home</a>
              </li>
              <li class="menu-item-has-children">
                <a href="#">Loại Sản Phẩm</a>
              </li>
              <li>
                <a href="#">Contact</a>
              </li>
            </ul>
          </nav>
        </div>
        <!-- menu end here -->
        <div class="header-item item-right">
          <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-search"></i></a>


          <?php
          if (isset($_SESSION['MaTaiKhoan'])) {
            // Session variable exists, allow the action
            echo '<a href="../../../controller/cartControll/cartHome.php?page=showCart"><i class="fas fa-shopping-cart"></i></a>';
          } else {
            // Session variable doesn't exist, block the action
            echo '<a href="#"><i class="fas fa-shopping-cart"></i></a>';
          }

          if (empty($_SESSION['MaTaiKhoan'])) {
            echo '<a href="/UTH-PHP/src/controller/AccountController/AccountController.php" id="login-btn" class="fas fa-user"></a>';
          } else {
            echo '<div class="btn-group loginSuccess">
            <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/UTH-PHP/src/public/template/frontEnd/img/loginSuccess.jpg" alt="img account">
            </button>
            <ul class="dropdown-menu dropdown-menu-lg-end">';

            if ($_SESSION['role'] !== 2) {
              echo '<li>
                <a class="dropdown-item" href="/UTH-PHP/src/controller/ProductController/ProductController.php">
                    <i class="fas fa-gear"></i> Admin
                </a>
            </li>';
            }

            echo '<li>
            <a class="dropdown-item" href="/UTH-PHP/src/controller/ThongTinUser/InformationController.php">
                <i class="fas fa-circle-info"></i>
                <span>Thông tin tài khoản</span>  
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="/UTH-PHP/src/view/xemlaidonhang/ctdonhang.php">
                <i class="fa-solid fa-wine-bottle"></i>
                <span>Chi tiết đơn hàng</span>  
            </a>
        </li>
        <li><a class="dropdown-item" href="/UTH-PHP/src/controller/AccountController/LogOutController.php"><i class="fas fa-arrow-right-from-bracket"></i> Log Out</a></li>
    </ul>
</div>';
          }
          ?> <!-- mobile menu trigger -->
          <div class="mobile-menu-trigger">
            <span></span>
          </div>
        </div>
      </div>
    </div>
  </header>


  <div class="container_profile containerPage">
    <?php
    require_once "$projectRoot/src/view/include/headerThongTinUser.php";
    ?>

    <div class="orderManagement_order_history">
      <div class="detail__wrapper">
        <p class="title">Chi tiết đơn hàng: <span id="orderID"><?php echo $dataDonHang->data[0]['MaDonHang'] ?></span></p>
        <ul class="order_status__wrapper" style="list-style: none;">
          <?php

          // Đặt các biến trạng thái mặc định
          $huy = "";
          $daDuyet = "";
          $dangGiao = "";
          $giaoThanhCong = "";
          if ($dataDonHang->data[0]['TenTrangThai'] == 'ChoDuyet') {
            $dataDonHang->data[0]['TenTrangThai'] = 'Chờ xác nhận';
          }
          if ($dataDonHang->data[0]['TenTrangThai'] == 'DaDuyet') {
            $dataDonHang->data[0]['TenTrangThai'] = 'Đã xác nhận';
          }
          if ($dataDonHang->data[0]['TenTrangThai'] == 'DangGiao') {
            $dataDonHang->data[0]['TenTrangThai'] = 'Đang giao hàng';
          }
          if ($dataDonHang->data[0]['TenTrangThai'] == 'GiaoThanhCong') {
            $dataDonHang->data[0]['TenTrangThai'] = 'Đã giao hàng';
          }
          if ($dataDonHang->data[0]['TenTrangThai'] == 'Huy') {
            $dataDonHang->data[0]['TenTrangThai'] = 'Đã hủy';
          }


          // Lặp qua các dòng dữ liệu và cập nhật trạng thái tương ứng
          foreach ($dataDonHang->data as $donhang) {
            switch ($donhang['TenTrangThai']) {
              case "Đã xác nhận":
                $daDuyet = "completed";
                break;
              case "Đang giao hàng":
                $dangGiao = "completed";
                break;
              case "Đã hủy":
                $huy = "cancel";
                break;
              case "Đã giao hàng":
                $giaoThanhCong = "completed";
                break;
            }
          }
          ?>
          <!--  -->
          <div class="order_status completed <?php echo $huy; ?>">
            <li>Đã đặt hàng</li>
          </div>
          <div class="order_status <?php echo $daDuyet . $huy . $giaoThanhCong; ?>">
            <li>Đã xác nhận</li>
          </div>
          <div class="order_status <?php echo $dangGiao . " " . $huy . $giaoThanhCong; ?>">
            <li>Đang giao hàng</li>
          </div>
          <div class="order_status <?php echo $giaoThanhCong . " " . $huy ?>">
            <li>Giao hàng thành công</li>
          </div>
        </ul>

        <div class="transaction_info__wrapper">
          <div class="receive_info__wrapper">
            <p class="title">Thông tin người nhận</p>
            <div class="divider"></div>
            <div class="receive_info">
              <p class="name"><span>Tên: </span><?php echo $dataDonHang->data[0]['HoTen'] ?></p>
              <p><span>Địa chỉ: </span><?php echo $dataDonHang->data[0]['DiaChiGiaoHang'] ?></p>
              <p><span>Số điện thoại: </span><?php echo $dataDonHang->data[0]['SoDienThoai'] ?></p>
            </div>
          </div>
          <div class="payment_method__wrapper">
            <p class="title">Phương thức thanh toán</p>
            <div class="divider"></div>
            <p><?php echo $dataDonHang->data[0]['TenPhuongThuc'] ?></p>
          </div>
          <div class="payment_method__wrapper">
            <p class="title">Phương thức vận chuyển</p>
            <div class="divider"></div>
            <p><?php echo $dataDonHang->data[0]['TenDichVu'] ?></p>
          </div>
        </div>
        <div class="transaction_items__wrapper">
          <p class="transaction_name">Trạng thái: <span class=""><?php echo $dataDonHang->data[0]['TenTrangThai'] ?></span></p>
          <div class="divider"></div>
          <div class="transaction_list">

            <?php
            $totalPrice = 0; // Khởi tạo biến tổng giá trị
            foreach ($dataDonHang->data as $donhang) {
              $totalPrice += $donhang['Gia'] * $donhang['SoLuong']; // Tính tổng giá trị
              echo "
              <div class='transaction_item'>
                <img  src='{$donhang['AnhMinhHoa']}' alt='thumbnail'>
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
          </div>
        </div>
        <div class="order_total__wrapper">
          <div>
            <p>Tổng tạm tính:</p>
            <p><?php echo number_format($totalPrice, 0, ',', '.') ?> VND</p>
          </div>
          <div>
            <p>Giảm giá:</p>
            <p>0 đ</p>
          </div>
          <div>
            <p>Phí vận chuyển:</p>
            <p>0 đ</p>
          </div>
          <div class="total">
            <p>Thành tiền:</p>
            <p><?php echo number_format($totalPrice, 0, ',', '.') ?> VND</p>
          </div>
        </div>
      </div>
    </div>

  </div>


  <?php require "$projectRoot/src/view/include/footer.php" ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    $(document).ready(() => {
      $('.btn-outline-danger').on('click', () => {
        var clickedIndex = 3;
        var completedIndex = $('.order_status.completed').length;
        console.log('completedIndex: ', completedIndex);
        console.log('clickedIndex: ', clickedIndex);
        if (clickedIndex !== completedIndex) {
          Swal.fire({
            icon: 'error',
            text: 'Đơn hàng chưa được duyệt.'
          });
          return;
        }

        if ($(this).hasClass('completed')) {
          Swal.fire({
            icon: 'info',
            text: 'Trạng thái này đã được cập nhật trước đó.'
          });
          return;
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

            if (clickedIndex == 3) {
              document.querySelectorAll('.order_status')[3].classList.add('complete');
              Swal.fire({
                icon: 'success',
                text: 'Cập nhật trạng thái thành công.'
              });
            } else {
              Swal.fire({
                icon: 'error',
                text: 'Không được cập nhật.'
              });
            }
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });
  </script>
</body>

</html>