<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/detailProduct.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head> 

<body>
<?php require "../../view/include/header.php"; ?>

  <!-- daiiiiiii -->
  <section style="margin-top: 140px;">
    <div class=" center-text">
      <div class="title_section">
        <div class="bar"></div>
        <h2 class="center-text-share">Chi tiết sản phẩm</h2>
      </div>
    </div>
  </section>


  <section>
    <div class="product-detail-wrapper">
      <div class="product__wrapper containerPage">
        <div class="product_images__wrapper">
          <div class="image">
            <img src="<?php echo $dataProduct['AnhMinhHoa'] ?>" alt="" class="product_img">
          </div>
          <div class="slider__wrapper">
            <div class="image__list_new">
              <div class="image_product_new view_more_image ">

              </div>
              <img class="active_image image_product_new" src="<?php echo $dataProduct['AnhMinhHoa'] ?>" alt="thumbnail">
            </div>

          </div>

        </div>
        <div class="info__wrapper">
          <div class="title__wrapper">
            <h2 class="title__wrapper"><?php echo $dataProduct['TenSanPham']; ?></h2>
          </div>
          <div class="price__wrapper">
            <p class="price"><?php echo number_format($dataProduct['Gia'], 0, ',', '.'); ?>&nbsp;đ</p>
          </div>
          <div class="divider"></div>
          <div class="detail_info__wrapper">
            <div class="specification__wrapper">
              <a href="/UTH-PHP/src/public/img/y.jpg" class="origin specification_item">
                <p><?php echo $dataProduct['XuatXu']; ?></p>
              </a>
              <a href="#" class="specification_item">
                <img class="" src="/UTH-PHP/src/public/img/ic_wine.png" alt="Loại sản phẩm">
                <p><?php echo $dataProduct['TenLoaiSanPham'] ?></p>
              </a>
              <div class="specification_item">
                <img class="" src="/UTH-PHP/src/public/img/ic_wine_alcohol_degree.png" alt="Nồng độ cồn">
                <p><?php echo $dataProduct['NongDoCon']; ?></p>
              </div>
              <div class="specification_item">
                <img class="" src="/UTH-PHP/src/public/img/ic_wine_bottle_size.png" alt="Thể tích">
                <p><?php echo $dataProduct['TheTich']; ?></p>
              </div>
            </div>
            <div class="rating__wrapper">
            </div>
            <div class="description__wrapper">
              <span class="title">Số lượng còn lại:</span>
              <span class="content content-so-luong-con-lai"><?php echo $dataProduct['SoLuongConLai'] ?></span>
            </div>
            <div>

            </div>
            <div class="size__wrapper">
              <p class="title">Dung tích</p>
              <div class="size__list">

                <div class="size__item ">
                  <p><?php echo $dataProduct['TheTich']; ?></p>
                </div>

              </div>
            </div>
            <div class="quantity__wrapper">
              <p class="title">Số lượng</p>
              <div class="quantity">
                <img class="button minus" src="/UTH-PHP/src/public/img/ic_minus.png" alt="icon">
                <input type="text" value="1" class="quantity-input">
                <img class="button plus" src="/UTH-PHP/src/public/img/ic_plus.png" alt="icon">
              </div>
            </div>
            <div class="button__wrapper">
              <button class="secondary" id="<?php echo $dataProduct['MaSanPham']; ?>">
                <img class="" src="/UTH-PHP/src/public/img/ic_cart.png" alt="icon">
                <span>Thêm vào giỏ hàng</span>
              </button>
            </div>
          </div>

        </div>
      </div>
  </section>
  <?php require "../../view/include/footer.php"; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $('.secondary').click(function(event) {
      event.preventDefault();
      var productId = $(this).attr('id');
      var quantity = $('.quantity-input').val();
      if (quantity === "") {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          timer: 1500,
          timerProgressBar: false,
          showConfirmButton: false,
          text: "Vui lòng nhập số lượng!",
        })
      }
      console.log(productId, quantity);
      $.ajax({
        type: 'POST',
        url: '/UTH-PHP/src/controller/cartControll/cartController.php',
        data: {
          action: 'addToCart',
          productId: productId,
          quantity: quantity
        },
        contentType: 'application/x-www-form-urlencoded',
        success: function(response) {
          const responseJSON = JSON.parse(response);
          console.log(responseJSON);
          if (responseJSON.status == 400) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              timer: 1500,
              timerProgressBar: false,
              showConfirmButton: false,
              text: responseJSON.message,
            }).then(() => {
              window.location.href = "/UTH-PHP/src/controller/AccountController/AccountController.php";
            });
            return;
          } else {
            showSuccessMessage('Thêm vào giỏ hàng thành công!')
          }
          console.log(productId)

          if (responseJSON.status == 401) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              timer: 1500,
              timerProgressBar: false,
              showConfirmButton: false,
              text: responseJSON.message,
            })
            return;
          }

          if (responseJSON.status == 402) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              timer: 1500,
              timerProgressBar: false,
              showConfirmButton: false,
              text: responseJSON.message,
            })
            return;
          }

          $('#message').text(response);
          try {
            if (cartCount > 0) {
              var subHtml = "<sub class='count_cart' style='margin-bottom: 10px; top: -10px; color: white; text-decoration: none; background-color: red; padding: 2px 5px; left: -10px; border-radius: 50%;'>" + cartCount + "</sub>";
              $('.cart').html("<a href='../../controller/cartControll/cartHome.php?page=showCart' style='text-decoration: none;'><img src='../../public/img/cart.png' alt='' />" + subHtml + "</a>");
            } else {
              $('.cart').html("<a href='../../controller/cartControll/cartHome.php?page=showCart' style='text-decoration: none;'><img src='../../public/img/cart.png' alt='' /></a>");
            }
          } catch (error) {
            console.error("Error parsing JSON: ", error);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    })

    $('.plus').click(function() {
      var quantityInput = $('.quantity-input');
      var currentValue = parseInt(quantityInput.val());
      var max = parseInt($('.content-so-luong-con-lai').text());
      if (quantityInput.val() === "") {
        // Sửa thành quantityInput thay vì quantityinput
        quantityInput.val(max);
        return;
      }
      if (currentValue < max) {
        quantityInput.val(currentValue + 1);
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Không thể tăng vượt quá số lượng còn lại !!',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    });

    $('.minus').click(function() {
      var quantityInput = $('.quantity-input');
      var currentValue = parseInt(quantityInput.val());
      if (quantityInput.val() === "") {
        // Sửa thành quantityInput thay vì quantityinput
        quantityInput.val(1);
        return;
      }

      if (currentValue > 1) {
        quantityInput.val(currentValue - 1);
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Không thể giảm được nữa !!',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    });


    function showSuccessMessage(message) {
      Swal.fire({
        icon: 'success',
        text: message,
        timer: 1000,
        timerProgressBar: false,
        showConfirmButton: false
      });
    }

    // Chọn trường input
    let quantityInput = document.querySelector('.quantity-input');
    quantityInput.addEventListener('input', function() {

      let value = this.value;
      if (isNaN(value) || parseFloat(value) <= 0) {

        this.value = 1;
      }

      if (parseInt(value) > parseInt($('.content-so-luong-con-lai').text())) {
        this.value = parseInt($('.content-so-luong-con-lai').text());
      }
    });
  </script>
</body>

</html>
