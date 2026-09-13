<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../../view/cart/thanhtoan.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <link rel="stylesheet" href="../../view/home/home.css" />

  <title>Document</title>
</head>

<body>
  <div>
    <?php require "../../view/include/header.php"; ?>

    <section style="margin-top: 90px;">
      <div class="center-text">
        <div class="title_section">
          <div class="bar"></div>
          <h2 class="center-text-share">Thanh Toán</h2>
        </div>
      </div>
    </section>
    <section>
      <div class="layout__wrapper">
        <!-- <form class="content__wrapper"> -->
        <div class="checkout__wrapper containerPage">
          <div class="payment_info__wrapper">
            <div class="payment_info">
              <!-- <p class="title">Thanh toán</p> -->
              <p class="receiver_info">Thông tin người nhận:</p>
              <?php
              if ($User->status == 200 && isset($User->data['HoTen'])) {
                $user = $User->data;
                echo "
                <div id='checkout_form'>
                    <div class='input__wrapper'>
                        <label for='username'>Họ tên:</label>
                        <input type='text' name='username' id='username' value='" . htmlspecialchars($user['HoTen']) . "' placeholder='Nhập họ tên' required/>
                    </div>
                    <div class='input__wrapper'>
                        <label for='phonenumber'>Số điện thoại:</label>
                        <input type='number' value='" . htmlspecialchars($user['SoDienThoai']) . "' name='phonenumber' id='phonenumber' placeholder='Nhập số điện thoại' required/>
                    </div>
                    <div class='input__wrapper'>
                        <label for='address'>Địa chỉ nhận hàng:</label>
                        <input type='text' name='address' id='address' value='" . htmlspecialchars($user['DiaChi']) . "' required/>
                    </div>
                    <div class='payment__wrapper'>
                        <label>Phương thức thanh toán:</label>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='payment' id='cash' value='1' checked='' required/>
                                <label for='cash'>Tiền mặt (COD)</label>
                            </div>
                        </div>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='payment' id='online' value='2' required/>
                                <label for='online'>Chuyển khoản ngân hàng</label>
                            </div>
                        </div>
                    </div>
                    <div class='payment__wrapper'>
                        <label>Phương thức vận chuyển:</label>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='shipping' id='ghtk' value='2' checked='' required/>
                                <label for='ghtk'>Giao hàng tiết kiệm</label>
                            </div>
                        </div>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='shipping' id='vcn' value='1' required/>
                                <label for='vcn'>Vận chuyển nhanh</label>
                            </div>
                        </div>
                    </div>
                    <div class='input__wrapper'>
                        <label for='note'>Ghi chú</label>
                        <textarea name='note' id='note' placeholder='Nhập ghi chú'></textarea>
                    </div>
                    <p class='hotline'>
                        * Để được hỗ trợ trực tiếp và nhanh nhất vui lòng liên hệ: 0325459901 by Đài
                    </p>
                </div>
                ";
            } else {
                echo "<div id='checkout_form'>
                    <div class='input__wrapper'>
                        <label for='username'>Họ tên:</label>
                        <input type='text' name='username' id='username' placeholder='Nhập họ tên' required/>
                    </div>
                    <div class='input__wrapper'>
                        <label for='phonenumber'>Số điện thoại:</label>
                        <input type='number' name='phonenumber' id='phonenumber' placeholder='Nhập số điện thoại' required/>
                    </div>
                    <div class='input__wrapper'>
                        <label for='address'>Địa chỉ nhận hàng:</label>
                        <input type='text' name='address' id='address' placeholder='Nhập địa chỉ' required/>
                    </div>
                    <div class='payment__wrapper'>
                        <label>Phương thức thanh toán:</label>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='payment' id='cash' value='1' checked='' required/>
                                <label for='cash'>Tiền mặt (COD)</label>
                            </div>
                        </div>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='payment' id='online' value='2' required/>
                                <label for='online'>Chuyển khoản ngân hàng</label>
                            </div>
                        </div>
                    </div>
                    <div class='payment__wrapper'>
                        <label>Phương thức vận chuyển:</label>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='shipping' id='ghtk' value='2' checked='' required/>
                                <label for='ghtk'>Giao hàng tiết kiệm</label>
                            </div>
                        </div>
                        <div class='radio__wrapper'>
                            <div>
                                <input type='radio' name='shipping' id='vcn' value='1' required/>
                                <label for='vcn'>Vận chuyển nhanh</label>
                            </div>
                        </div>
                    </div>
                    <div class='input__wrapper'>
                        <label for='note'>Ghi chú</label>
                        <textarea name='note' id='note' placeholder='Nhập ghi chú'></textarea>
                    </div>
                    <p class='hotline'>
                        * Để được hỗ trợ trực tiếp và nhanh nhất vui lòng liên hệ: 0325459901 by Đài
                    </p>
                </div>";
            }
              ?>
            </div>
          </div>
          <div class="order_info__wrapper">
            <div class="order_info">
              <p class="title">Thông tin đơn hàng</p>
              <div class="divider"></div>
              <div class="info__wrapper">
                <p>Mã giảm giá</p>
                <p class="clickable">Nhập mã</p>
              </div>
              <div class="divider"></div>
              <div class="detail_info__wrapper">
                <div class="info__wrapper">
                  <p>Tạm tính</p>
                  <p> <?php echo number_format($totalPrice, 0, ',', '.')  ?>&nbsp;đ</p>
                </div>
                <div class="info__wrapper">
                  <p>Giảm giá</p>
                  <p>0</p>
                </div>
                <div class="info__wrapper">
                  <p>Phí vận chuyển</p>
                  <p>0&nbsp;đ</p>
                  <!-- <a href="#">Chính Sách Giao Hàng</a> -->
                </div>
              </div>
              <div class="divider"></div>
              <div class="info__wrapper total__info">
                <p>Tổng cộng</p>
                <p><?php echo number_format($totalPrice_Shipping, 0, ',', '.') ?>&nbsp;đ</p>
              </div>
              <button class="button">Đặt hàng</button>
            </div>
          </div>
        </div>
        <!-- </form> -->
      </div>
    </section>
    <?php require "../../view/include/footer.php"; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    const showErrorAlert = (message) => {
      Swal.fire({
        icon: "error",
        title: "Lỗi!",
        text: message,
      });
    };


    $(document).ready(function() {
      $('.button').on('click', function() {
        var urlParams = new URLSearchParams(window.location.search);

        var productInfoJSON = urlParams.get('productInfo');

        var productInfo = JSON.parse(decodeURIComponent(productInfoJSON));

        // console.log(productInfo);
        var username = $('#username').val();
        var phoneNumber = $('#phonenumber').val();
        var address = $('#address').val();
        var paymentMethod = $('input[name="payment"]:checked').val();
        var shippingMethod = $('input[name="shipping"]:checked').val();
        var checkValidate = validateForm()
        if (!checkValidate) {
          return;
        }
        $.ajax({
          url: '../../controller/cartControll/cartController.php',
          method: 'POST',
          action: 'thanhtoan',
          data: {
            productInfo: JSON.stringify(productInfo),
            username: username,
            phoneNumber: phoneNumber,
            address: address,
            paymentMethod: paymentMethod,
            shippingMethod: shippingMethod,
            action: 'thanhtoan'
          },
          success: function(response) {
            showSuccessMessage('Đặt hàng thành công!');
            setTimeout(function() {
              window.location.href = '../../controller/cartControll/cartHome.php';
            }, 1000);
          },
          error: function(xhr, status, error) {
            console.error(error);
          }
        });
      });
    });

    function validateForm() {
      var username = document.getElementById('username').value;
      var phonenumber = document.getElementById('phonenumber').value;
      var address = document.getElementById('address').value;
      var paymentMethod = document.querySelector('input[name="payment"]:checked');
      var shippingMethod = document.querySelector('input[name="shipping"]:checked');

      // Biểu thức chính quy cho tên người dùng, yêu cầu ít nhất một chữ cái, không bao gồm ký tự đặc biệt và số
      var usernameRegex = /^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/;

      // Biểu thức chính quy cho số điện thoại, yêu cầu từ 10 đến 11 chữ số
      var phonenumberRegex = /^\d{10,11}$/;

      // Kiểm tra họ tên
      if (!usernameRegex.test(username)) {
        showErrorAlert('Họ tên không hợp lệ. Vui lòng nhập lại.');
        return false;
      }

      // Kiểm tra số điện thoại
      if (!phonenumberRegex.test(phonenumber)) {
        showErrorAlert('Số điện thoại không hợp lệ. Vui lòng nhập lại.');
        return false;
      }

      // Kiểm tra địa chỉ
      if (address.trim() === '') {
        showErrorAlert('Địa chỉ không được để trống. Vui lòng nhập lại.');
        return false;
      }

      // Kiểm tra phương thức thanh toán
      if (!paymentMethod) {
        showErrorAlert('Vui lòng chọn phương thức thanh toán.');
        return false;
      }

      // Kiểm tra phương thức vận chuyển
      if (!shippingMethod) {
        showErrorAlert('Vui lòng chọn phương thức vận chuyển.');
        return false;
      }

      // Nếu các thông tin nhập vào đều hợp lệ, trả về true
      return true;
    }
  </script>
</body>

</html>