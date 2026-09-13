<div class="sidebar_sidebar__wrapper">
  <!-- <div class="sidebar_background__LJA4M"></div> -->
  <div class="sidebar_sidebar">
    <div class="avatar" style="height: 60px; display: flex; justify-content: center; align-item: center;">
      <img class=" " style="height: 60px; " src="/UTH-PHP/src/public/img/avatar.png" alt="thumbnail" />
    </div>
    <div class="sidebar_divider"></div>
    <div class="sidebar_sidebar_item__wrapper">
      <a class="sidebar_sidebar__item" href="/UTH-PHP/src/controller/ThongTinUser/InformationController.php">
        <img class=" " src="/UTH-PHP/src/public/img/ic_sidebar_person.png" data-src="/assets/icons/ic_sidebar_person.png" alt="icon" />
        <span>Thông tin cá nhân</span>
      </a>
      <?php
      $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
      require_once $projectRoot . '/src/model/AccountModels/NguoiDungModel.php';

      $modelNguoiDung = new NguoiDungModel();
      

     
        $checkMaTaiKhoan = $modelNguoiDung->getFullMaTaiKhoan();
        if ($checkMaTaiKhoan->status === 200) {
          foreach ($checkMaTaiKhoan->data as $maTaiKhoan) {
            if ($maTaiKhoan["MaTaiKhoan"] === $_SESSION["MaTaiKhoan"]) {
              echo '<a class="sidebar_sidebar__item" href="/UTH-PHP/src/controller/ThongTinUser/UpdateInfoController.php">
            <img class=" " src="/UTH-PHP/src/public/img/ic_sidebar_person.png" data-src="/assets/icons/ic_sidebar_map-pin.png" alt="icon" />
            <span>Cập nhật thông tin</span>
          </a>';
              break;
            }
          }
        }
      
      ?>
      <a class="sidebar_sidebar__item" href="/UTH-PHP/src/view/xemlaidonhang/ctdonhang.php">
        <img class=" " src="/UTH-PHP/src/public/img/ic_sidebar_document.png" data-src="/assets/icons/ic_sidebar_map-pin.png" alt="icon" />
        <span>Quản lý đơn hàng</span>
      </a>

    </div>
    <div class="sidebar_divider"></div>
  </div>
</div>
