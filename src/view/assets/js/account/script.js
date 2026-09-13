const container = document.getElementById("container");
const registerBtn = document.getElementById("register");
const loginBtn = document.getElementById("login");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});

const showSuccessAlert = () => {
  Swal.fire({
    icon: "success",
    title: "Thành công!",
    text: "Xử lý thành công.",
  });
};

const showErrorAlert = (message) => {
  Swal.fire({
    icon: "error",
    title: "Lỗi!",
    text: message,
  });
};

$(document).ready(() => {
  $("#loginForm").submit((event) => {
    event.preventDefault(); // Ngăn chặn gửi yêu cầu mặc định
    const formData = new FormData(event.target); // Tạo một đối tượng FormData từ biểu mẫu
    formData.append("action", "signin"); // Thêm action vào dữ liệu gửi đi
    console.log(formData);
    $.ajax({
      type: "POST", // Phương thức POST
      url: "/UTH-PHP/src/controller/AccountController/AccountController.php", // Đường dẫn đến tệp xử lý PHP
      data: formData, // Dữ liệu gửi đi với action signin
      processData: false,
      contentType: false,
      success: (response) => {
        // Xử lý kết quả thành công
        const responseJSON = JSON.parse(response);
        console.log(responseJSON);
        if (responseJSON.status === 200) {
          Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: 'Xử lý thành công.',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "/UTH-PHP/src/controller/HomeController/HomeController.php";
            }
          });
        } else {
          showErrorAlert(responseJSON.message);
          // Đăng nhập không thành công, hiển thị thông báo lỗi
        }
      },
      error: (xhr, status, error) => {
        // Xử lý lỗi
        console.error(xhr.responseText); // Log lỗi ra console
        showErrorAlert("Có lỗi xảy ra, vui lòng thử lại sau.");
      },
    });
  });

  $("#registerForm").submit((event) => {
    event.preventDefault(); // Ngăn chặn gửi yêu cầu mặc định
    const formData = new FormData(event.target); // Tạo một đối tượng FormData từ biểu mẫu
    formData.append("action", "register"); // Thêm action vào dữ liệu gửi đi
    console.log(formData);
    $.ajax({
      type: "POST", // Phương thức POST
      url: "/UTH-PHP/src/controller/AccountController/AccountController.php", // Đường dẫn đến tệp xử lý PHP
      data: formData, // Dữ liệu gửi đi với action register
      processData: false,
      contentType: false,
      success: (response) => {
        // Xử lý kết quả thành công
        const responseJSON = JSON.parse(response);
        console.log(responseJSON);
        if (responseJSON.status === 200) {
          Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: 'Xử lý thành công.',
          }).then((result) => {
            if (result.isConfirmed) {
              // Reload trang khi người dùng nhấn OK
              window.location.reload();
            }
          });
        } else {
          showErrorAlert(responseJSON.message);
        }
      },
      error: (xhr, status, error) => {
        // Xử lý lỗi
        console.error(xhr.responseText); // Log lỗi ra console
        showErrorAlert("Có lỗi xảy ra, vui lòng thử lại sau.");
      },
    });
  });

});




