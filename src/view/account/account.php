<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/login/style.css" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css" />
  <title>Login</title>
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-up">
      <form id="registerForm" method="POST">
        <h1 style="font-size: 2rem">Create Account</h1>
        <!-- <span>or use your email for registeration</span> -->
        <input type="text" placeholder="Username" id="username" name="username" required />
        <input type="email" placeholder="Email" id="email" name="email" required />
        <input type="password" placeholder="Password" id="passwordSignUp" name="password" required />
        <input type="text" placeholder="Password" id="passwordVisibleSignUp" style="display: none;" readonly />
        <i class="fa-regular fa-eye" id="togglePasswordSignUp" style="position: absolute;top: 261px;right: 50px;cursor: pointer;"></i>
        <input type="password" placeholder="Confirm password" id="confirmPassword" name="confirmPassword" required />
        <button type="submit" class="btn btn-danger">Đăng kí</button>
      </form>
    </div>
    <div class="form-container sign-in">
      <form id="loginForm" method="POST">
        <h1>Sign In</h1>

        <!-- <span>or use your email password</span> -->
        <input type="text" placeholder="Username" id="username" name="username" required />
        <input type="password" placeholder="Password" id="passwordSignIn" name="password" required />
        <input type="text" placeholder="Password" id="passwordVisibleSignIn" style="display: none;" readonly />
        <i class="fa-regular fa-eye" id="togglePasswordSignIn" style="position: absolute;top: 267px;right: 50px;cursor: pointer;"></i>
        <button type="submit" class="btn btn-danger">Đăng nhập</button>
      </form>
    </div>
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Đã có tài khoản</h1>
          <!-- <p>Enter your personal details to use all of site features</p> -->
          <button type="button" class="btn btn-light" id="login">
            Đăng nhập
          </button>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Chưa có tài khoản</h1>
          <!-- <p>
            Register with your personal details to use all of site features
          </p> -->
          <button type="button" class="btn btn-light" id="register">
            Đăng kí
          </button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var passwordInput = document.getElementById("passwordSignIn");
      var passwordVisibleInput = document.getElementById("passwordVisibleSignIn");
      var toggleIcon = document.getElementById("togglePasswordSignIn");
      var isMouseDown = false; // Biến để theo dõi trạng thái chuột

      // Sự kiện nhấn chuột
      toggleIcon.addEventListener("mousedown", function(event) {
        // Hủy bỏ hành động mặc định của sự kiện mousedown (tránh chuyển trang)
        event.preventDefault();
        isMouseDown = true; // Đặt cờ khi chuột được nhấn
        // Kiểm tra kiểu của passwordInput và thực hiện tương ứng
        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          passwordVisibleInput.value = passwordInput.value; // Cập nhật giá trị của thẻ input hiển thị mật khẩu
          toggleIcon.classList.remove("fa-eye");
          toggleIcon.classList.add("fa-eye-slash");
          passwordVisibleInput.style.display = "block";
          passwordInput.style.display = "none";
        }
      });

      // Sự kiện thả chuột
      toggleIcon.addEventListener("mouseup", function() {
        // Kiểm tra nếu chuột đã được nhấn trước đó
        if (isMouseDown) {
          // Chỉ thay đổi lại kiểu khi chuột được nhấn
          passwordInput.type = "password";
          passwordVisibleInput.value = ""; // Xóa giá trị của thẻ input hiển thị mật khẩu
          toggleIcon.classList.remove("fa-eye-slash");
          toggleIcon.classList.add("fa-eye");
          passwordVisibleInput.style.display = "none";
          passwordInput.style.display = "block";
        }
        isMouseDown = false; // Đặt lại cờ khi chuột được thả ra
      });

      // Sự kiện rời khỏi biểu tượng (chỉ áp dụng khi giữ chuột không hoạt động)
      toggleIcon.addEventListener("mouseleave", function() {
        // Kiểm tra nếu chuột đã được nhấn trước đó
        if (isMouseDown) {
          // Chỉ thay đổi lại kiểu khi chuột được nhấn
          passwordInput.type = "password";
          passwordVisibleInput.value = ""; // Xóa giá trị của thẻ input hiển thị mật khẩu
          toggleIcon.classList.remove("fa-eye-slash");
          toggleIcon.classList.add("fa-eye");
          passwordVisibleInput.style.display = "none";
          passwordInput.style.display = "block";
        }
        isMouseDown = false; // Đặt lại cờ khi chuột được thả ra
      });
    });

    document.addEventListener("DOMContentLoaded", function() {
      var passwordInput = document.getElementById("passwordSignUp");
      var passwordVisibleInput = document.getElementById("passwordVisibleSignUp");
      var toggleIcon = document.getElementById("togglePasswordSignUp");

      var mouseDown = false;

      toggleIcon.addEventListener("mousedown", function() {
        mouseDown = true;
        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          passwordVisibleInput.value = passwordInput.value; // Cập nhật giá trị của thẻ input hiển thị mật khẩu
          toggleIcon.classList.remove("fa-eye");
          toggleIcon.classList.add("fa-eye-slash");
        }
      });

      document.addEventListener("mouseup", function() {
        if (mouseDown) {
          mouseDown = false;
          passwordInput.type = "password";
          passwordVisibleInput.value = ""; // Xóa giá trị của thẻ input hiển thị mật khẩu
          toggleIcon.classList.remove("fa-eye-slash");
          toggleIcon.classList.add("fa-eye");
        }
      });

      toggleIcon.addEventListener("mouseleave", function() {
        if (mouseDown) {
          mouseDown = false;
          passwordInput.type = "password";
          passwordVisibleInput.value = ""; // Xóa giá trị của thẻ input hiển thị mật khẩu
          toggleIcon.classList.remove("fa-eye-slash");
          toggleIcon.classList.add("fa-eye");
        }
      });
    });
  </script>
  <script src="/UTH-PHP/src/view/assets/js/account/script.js"></script>
</body>

</html>
