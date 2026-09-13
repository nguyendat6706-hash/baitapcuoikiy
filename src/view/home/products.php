<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <script src="js/bootstrap.js"></script>
  <link rel="stylesheet" href="../../public/template/frontEnd/home/login.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <title>Document</title>
</head>

<body>
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
            echo '<a href="/UTH-PHP/src/controller/cartControll/cartHome.php?page=showCart"><i class="fas fa-shopping-cart"></i></a>';
          } else {
            // Session variable doesn't exist, block the action
            echo '<a href="#"><i class="fas fa-shopping-cart"></i></a>';
          }

          if (empty($_SESSION['MaTaiKhoan'])) {
            echo '<a href="../AccountController/AccountController.php" id="login-btn" class="fas fa-user"></a>';
          } else {
            echo '<div class="btn-group loginSuccess">
            <button type="button" class="btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/UTH-PHP/src/public/template/frontEnd/img/loginSuccess.jpg" alt="img account">
            </button>
            <ul class="dropdown-menu dropdown-menu-lg-end">';

            if ($_SESSION['role'] != 2) {
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
          ?>
          <!-- mobile menu trigger -->
          <div class="mobile-menu-trigger">
            <span></span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section style="padding-top: 48px">
    <div class="center-text">
      <div class="title_section">
        <div class="bar"></div>
        <h2 class="center-text-share">TẤT CẢ SẢN PHẨM</h2>
      </div>
    </div>
    <div class="icon-bottom-title">
      <img src="../../../img/design/line.webp" alt="" />
    </div>
  </section>
  <div class="searchName">
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Search
      </button> -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <input class="form-control search-product-input" type="text" placeholder="Tên Sản Phẩm">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- daiiiiiii -->
  <section class="mb-3" id="product">
    <div class="products">
      <?php
      foreach ($dataSanPham->data as $product) {
        echo '
    <div class="row">
        <a href="#">

            <img src="' . $product['AnhMinhHoa'] . '" alt="' . $product['TenSanPham'] . '" class="product-image" data-productId="' . $product['MaSanPham'] . '"/>
            <div class="product-card-content">
                <div class="price" style="width:100%;">
                    <h4 class="name-product">' . $product['TenSanPham'] . '</h4>
                    <p class="price-tea">' . number_format($product['Gia'], 0, ',', '.') . 'đ</p>
                </div>
                <div class="buy-btn-container">
                    <button type="submit" data-productId="' . $product['MaSanPham'] . '" class="add-to-cart-btn" data-productId="' . $product['MaSanPham'] . '"> Thêm vào giỏ hàng</button>
                </div>
            </div>
        </a>
    </div>';
      }
      ?>
    </div>
  </section>
  <?php require "../../view/include/footer.php"; ?>





  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function showSuccessMessage(message) {
      Swal.fire({
        icon: 'success',
        // title: 'Success!',
        text: message,
        timer: 1000,
        timerProgressBar: false,
        showConfirmButton: false
      });
    }

    // -----------them gio hang user------------
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="/UTH-PHP/src/view/assets/js/home/script.js"></script>
</body>
