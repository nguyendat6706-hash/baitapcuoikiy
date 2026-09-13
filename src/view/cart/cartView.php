<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../../view/assets/css/homepage.css">
  <link rel="stylesheet" href="../../view/home/home.css">
  <link rel="stylesheet" href="../../view/cart/cartView.css">
  <title>Document</title>
</head>

<body>
  <div>

    <!-- daiiiiiiiiiii -->
    <?php require "../../view/include/header.php"; ?>

    <section>
      <div class="center-text" style="margin-top: 70px;">

        <div class="title_section">
          <div class="bar"></div>
          <h2 class="center-text-share">Giỏ Hàng Của Bạn</h2>
        </div>
      </div>
    </section>



    <section class="show_cart">
      <?php
      $numberOfProducts = count(array_unique(array_column($data->data, 'MaSanPham')));
      if ($numberOfProducts > 0) {
      ?>
        <div class="page_cart containerPage">
          <div class="wrapListCart">

            <p class="quantityCart">Bạn đang có <span class="totalProducts"><?php echo $numberOfProducts; ?></span> sản phẩm trong giỏ hàng <?php echo $_SESSION['username']; ?></p>
            <div class="listCart">
              <?php
              foreach ($data->data as $cartProduct) {
                echo "
        <div class='cartItem' id='{$cartProduct['MaSanPham']}'>
            <a href='#' class='img'><img class='img' src='{$cartProduct['AnhMinhHoa']}' /></a>
            <div class='inforCart'>
                <div class='nameAndPrice'>
                    <a href='#' class='nameCart'>{$cartProduct['TenSanPham']}</a>
                    <p class='priceCart'>" . number_format($cartProduct['DonGia'], 0, ',', '.') . "&nbsp;đ</p>
                </div>
                <div class='quantity'>
                    <button class='btnQuantity decrease'>-</button>
                    <input type='number' class='txtQuantity' value='{$cartProduct['SoLuong']}' min='1' max='{$cartProduct['SoLuongConLai']}' oninput='handleInput(this)'>
                    <button class='btnQuantity increase'>+</button>
                </div>
            </div>
            <div class='wrapTotalPriceOfCart'>
                <div class='totalPriceOfCart'>
                    <p class='lablelPrice'>Thành tiền</p>
                    <p class='valueTotalPrice'>" . number_format($cartProduct['ThanhTien'], 0, ',', '.') . "&nbsp;đ</p>
                </div>
                <button class='btnRemove'>
                    <i class='fa-solid fa-xmark'></i>
                </button>
            </div>
        </div>";
              }
              ?>

            </div>
          </div>
          <div class="wrapInfoOrder">
            <div class="bg_infoOrder"></div>
            <div class="infoOrder">
              <p class="titleOrder">Thông tin đơn hàng</p>
              <div class="wrapPriceTotal">
                <p class="titlePriceTotal">Tạm tính:</p>
                <p class="priceTotal"><?php
                                      $total = 0;
                                      foreach ($data->data as $cartProduct) {
                                        $total = $cartProduct['ThanhTien'] + $total;
                                      }
                                      echo number_format($total, 0, ',', '.') ?>&nbsp;đ</p>
              </div>
              <!-- <a href="#" class="btnCheckout"> -->
              <button class="btnCheckout">Tiến hành đặt hàng</button>
              <!-- </a> -->
              <a href="/UTH-PHP/src/controller/HomeController/HomeController.php">
                <button class="btnCheckout_buy">Tiếp tục mua hàng</button>
              </a>
            </div>
          </div>
        </div>
      <?php
      } else {
        echo "<p class='emty_cart' style='margin: 150px 0 200px;
    display: flex;
    justify-content: center;'>Giỏ hàng của bạn trống!</p>";
      }
      ?>
    </section>

    <?php require "../../view/include/footer.php"; ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    function handleInput(input) {
      var value = parseInt(input.value);
      var max = parseInt(input.getAttribute('max'));
      var min = parseInt(input.getAttribute('min'));

      // Nếu giá trị lớn hơn giá trị max, thiết lập giá trị của input là max
      if (value > max) {
        input.value = max;
        value = max
      }

      // Nếu giá trị nhỏ hơn giá trị min, thiết lập giá trị của input là min
      if (value < min) {
        input.value = min;
        value = min
      }
      var btn = $(input);
      var quantityField = btn.closest('.quantity').find('.txtQuantity');
      var cartItem = btn.closest('.cartItem');
      var productId = cartItem.attr('id');

      console.log(value)
      $.ajax({
        url: '../../controller/cartControll/cartController.php',
        method: 'POST',
        data: {
          productId: productId,
          action: "inputSoLuong",
          newQuantity: value
        },
        success: function(response) {
          console.log(response);
          var responseData = JSON.parse(response);
          if (responseData.error) {
            showErrorMessage(responseData.error);
            if (responseData.newQuantity !== undefined) {
              quantityField.val(responseData.newQuantity);
            }
          } else {
            quantityField.val(responseData.newQuantity);
            cartItem.find('.valueTotalPrice').text(responseData.valueTotalPrice);
            $('.priceTotal').text(responseData.totalPrice);
            showSuccessMessage('Product quantity updated successfully!');
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    function showErrorMessage(message) {
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: message,
        showConfirmButton: true
      });
    }

    // ajax tang giam so luong
    $(document).ready(function() {
      $('.btnQuantity').on('click', function() {
        var btn = $(this);
        var quantityField = btn.closest('.quantity').find('.txtQuantity');
        var action = btn.hasClass('increase') ? 'increase' : 'decrease';
        var cartItem = btn.closest('.cartItem');
        var productId = cartItem.attr('id');
        var currentQuantity = parseInt(quantityField.val());
        if (action === 'decrease' && currentQuantity <= 1) {
          quantityField.val('1');
          showErrorMessage('số lượng không được nhỏ hơn 1')
          return;
        }

        $.ajax({
          url: '../../controller/cartControll/cartController.php',
          method: 'POST',
          data: {
            productId: productId,
            action: action
          },
          success: function(response) {
            console.log(response);
            var responseData = JSON.parse(response);
            if (responseData.error) {
              showErrorMessage(responseData.error);
              if (responseData.newQuantity !== undefined) {
                quantityField.val(responseData.newQuantity);
              }
            } else {
              quantityField.val(responseData.newQuantity);
              cartItem.find('.valueTotalPrice').text(responseData.valueTotalPrice);
              $('.priceTotal').text(responseData.totalPrice);
              showSuccessMessage('Product quantity updated successfully!');
            }
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });





    // ajax xoa tung san pham
    $(document).ready(function() {
      $('.btnRemove').on('click', function() {
        var productId = $(this).closest('.cartItem').attr('id');
        $.ajax({
          url: '../../controller/cartControll/cartController.php',
          method: 'POST',
          data: {
            productId: productId,
            action: 'deleteCart'
          },
          success: function(response) {
            console.log(response);
            try {
              var responseData = JSON.parse(response);
              $('#' + productId).remove();
              $('.priceTotal').text(responseData.priceTotal);
              $('.totalProducts').text(responseData.quantityCart);

              // Kiểm tra nếu không còn sản phẩm trong giỏ hàng, hiển thị thông báo
              if (parseInt(responseData.quantityCart) === 0) {
                $('.containerPage').hide();
                $('.show_cart').html("<p class='emty_cart ' style=' margin: 150 px 0 200 px; display: flex; justify - content: center'>Giỏ hàng của bạn trống!</p>")
              } else {
                $('.containerPage').show();
                $('.emty_cart').hide();
              }
            } catch (error) {
              console.error("Error parsing JSON: ", error);
            }
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });


    // $(document).ready(function() {
    //   $('.txtQuantity').on('input', function() {
    //     var inputField = $(this);
    //     var quantity = parseInt(inputField.val());
    //     var maxQuantity = parseInt(inputField.attr('max'));
    //     var minQuantity = parseInt(inputField.attr('min'));

    //     if (quantity > maxQuantity) {
    //       showErrorMessage('vượt quá số lượng còn lại của sản phẩm')
    //       inputField.val(maxQuantity);
    //     }
    //     if (quantity < minQuantity) {
    //       showErrorMessage('vui lòng nhập số lượng lớn hơn 1')
    //       inputField.val(minQuantity);
    //     }
    //     var totalPrice = price * quantity;
    //     inputField.closest('.cartItem').find('.valueTotalPrice').text(totalPrice) + "&nbsp;đ";
    //   });
    // });


    // let quantityInput = document.querySelector('.txtQuantity');
    // quantityInput.addEventListener('input', function() {

    //   let value = this.value;
    //   if (isNaN(value) || parseFloat(value) <= 0) {

    //     this.value = 1;
    //   }

    //   if (parseInt(value) > parseInt(quantityInput.val())) {
    //     this.value = parseInt(quantityInput.val());
    //   }
    // });




    function getProductInfo() {
      var productInfo = [];
      var cartItems = document.querySelectorAll('.cartItem');

      cartItems.forEach(function(item) {
        var productId = item.id;
        var quantity = item.querySelector('.txtQuantity').textContent;
        productInfo.push({
          productId: productId,
          quantity: quantity
        });
      });

      return productInfo;
    }

    document.querySelector('.btnCheckout').addEventListener('click', function() {
      window.location.href = '../../controller/cartControll/cartHome.php?page=thanhtoan';
    });
  </script>
</body>

</html>