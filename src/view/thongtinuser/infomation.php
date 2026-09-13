<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/thongtinuser/infomation.css">
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Thông tin cá nhân</title>
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



    <div class="orderManagement_order_history">
      <p class="orderManagement_title">Thông tin cá nhân</p>

      <div id="infomation-group">
        <div id="infomation-page">
          <?php
          if ($nguoiDung->status === 200) {
            $info = $nguoiDung->data; // Get the data object
          ?>
            <div>
              <div class='infomation'>
                <p class='information-child'>Họ và tên:</p>
                <p class='info-value'> <?php echo !empty($info['HoTen']) ? $info['HoTen'] : 'Chưa cập nhật thông tin'; ?> </p>
              </div>

              <div class='infomation'>
                <p class='information-child'>Ngày sinh:</p>
                <p class='info-value'> <?php echo !empty($info['NgaySinh']) ? $info['NgaySinh'] : 'Chưa cập nhật thông tin'; ?></p>
              </div>

              <div class='infomation'>
                <p class='information-child'>Giới tính:</p>
                <p class='info-value'> <?php echo !empty($info['GioiTinh']) ? $info['GioiTinh'] : 'Chưa cập nhật thông tin'; ?></p>
              </div>

              <div class='infomation'>
                <p class='information-child'>Số điện thoại:</p>
                <p class='info-value'> <?php echo !empty($info['SoDienThoai']) ? $info['SoDienThoai'] : 'Chưa cập nhật thông tin'; ?></p>
              </div>

              <div class='infomation'>
                <p class='information-child'>Email:</p>
                <p class='info-value'> <?php echo !empty($info['Email']) ? $info['Email'] : 'Chưa cập nhật thông tin'; ?></p>
              </div>

              <div class='infomation'>
                <p class='information-child'>Địa chỉ:</p>
                <p class='info-value'> <?php echo !empty($info['DiaChi']) ? $info['DiaChi'] : 'Chưa cập nhật thông tin'; ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php
  require_once "$projectRoot/src/view/include/footer.php";
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
