<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="/UTH-PHP/src/view/thongtinuser/updateinfo.css">
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <title>Cập nhật thông tin</title>
</head>

<body>
  <?php
  require_once "$projectRoot/src/view/include/header.php";
  ?>
  <div class="container_profile containerPage">
    <?php
    $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
    require_once "$projectRoot/src/view/include/headerThongTinUser.php";
    ?>

    <div id="Info-form-logout">
      <div id="info-form">
      </div>
      <form class="info-form-sending" method="POST">
        <h1 class="info-title">Cập nhật thông tin cá nhân</h1>
        <div class="info-profile">
          <label for="name" class="info-user">Họ tên</label>
          <div class="info-input">
            <input type="text" name="name" id="name" placeholder="Nhập tên" class="info-input-value" value="<?php echo isset($data['HoTen']) ? $data['HoTen'] : ''; ?>" required>
          </div>
        </div>
        <div class="info-profile">
          <label for="email" class="info-user">E-mail</label>
          <div class="info-input">
            <input type="email" name="email" id="email" placeholder="Nhập email" class="info-input-value" value="<?php echo isset($data['Email']) ? $data['Email'] : ''; ?>" required >
          </div>
        </div>
        <div class="info-profile">
          <label for="phone" class="info-user">Số điện thoại</label>
          <div class="info-input">
            <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" class="info-input-value" value="<?php echo isset($data['SoDienThoai']) ? $data['SoDienThoai'] : ''; ?>" required>
          </div>
        </div>
        <div class="info-profile">
          <label for="gender" class="info-user">Giới tính</label>
          <div class="info-gender">
            <label for="gender_male" class="info-gender-radio">
              <input type="radio" name="gender" id="gender_male" value="Male" <?php echo isset($data['GioiTinh']) && $data['GioiTinh'] === 'Male' ? 'checked' : ''; ?>>
              <span>Nam</span>
            </label>
            <label for="gender_female" class="info-gender-radio">
              <input type="radio" name="gender" id="gender_female" value="Female" <?php echo isset($data['GioiTinh']) && $data['GioiTinh'] === 'Female' ? 'checked' : ''; ?>>
              <span>Nữ</span>
            </label>
          </div>
        </div>
        <div class="info-profile">
          <label for="info-dayOfBirth" class="info-user">Ngày sinh</label>
          <input type="date" name="info-date" id="info-dayOfBirth" class="info-input-value" value="<?php echo isset($data['NgaySinh']) ? $data['NgaySinh'] : ''; ?>" required>
        </div>
        <div class="info-profile">
          <label for="label-address" class="info-user">Địa chỉ</label>
          <input type="text" name="info-address" id="info-address" class="info-input-value" value="<?php echo isset($data['DiaChi']) ? $data['DiaChi'] : ''; ?>" required>
        </div>
        <div class="info-profile" style="display: none;">
          <label for="label-maQuyen" class="info-user">Mã Quyền</label>
          <input type="text" name="info-maQuyen" id="info-maQuyen" disabled class="info-input-value" value="<?php echo isset($data['MaQuyen']) ? $data['MaQuyen'] : ''; ?>" required>
        </div>
        <div class="info-profile" style="display: none;">
          <label for="label-maTaiKhoan" class="info-user">Mã Tài Khoản</label>
          <input type="text" name="info-maTaiKhoan" id="info-maTaiKhoan" disabled class="info-input-value" value="<?php echo isset($data['MaTaiKhoan']) ? $data['MaTaiKhoan'] : ''; ?>" required>
        </div>
        <div class="info-profile" style="display: none;">
          <label for="label-doiTuong" class="info-user">Đối Tượng</label>
          <input type="text" name="info-doiTuong" id="info-doiTuong" disabled class="info-input-value" value="<?php echo isset($data['DoiTuong']) ? $data['DoiTuong'] : ''; ?>" required>
        </div>
        <div class="info-profile">
          <button type="submit" class="info-submit-btn">Cập nhật thông tin</button>
        </div>
      </form>
    </div>
  </div>
  </div>
  <?php
  require_once "$projectRoot/src/view/include/footer.php";
  ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/UTH-PHP/src/view/assets/js/thongTinUser/updateInfo.js">
</script>

</html>
