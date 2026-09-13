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
          echo '<a href="../../controller/cartControll/cartHome.php?page=showCart"><i class="fas fa-shopping-cart"></i></a>';
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