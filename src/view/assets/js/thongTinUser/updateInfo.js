$(document).ready(() => {
  $('.info-form-sending').on('submit', (e) => {
    e.preventDefault(); // Prevent the form from submitting normally

    // Serialize form data
    const formData = new FormData(e.currentTarget);

    // Append values of disabled input fields
    $('.info-form-sending input[disabled]').each(function() {
      formData.append($(this).attr('name'), $(this).val());
    });

    formData.append('action', "updateInformationUser");

    // Send Ajax request
    $.ajax({
      type: 'POST',
      url: '/UTH-PHP/src/controller/ThongTinUser/UpdateInfoController.php', // URL to send the request
      data: formData, // Form data
      processData: false,
      contentType: false,
      dataType: 'json', // Parse response as JSON
      success: (response) => {
        if (response.status === 200) {
          showSuccessAlert();
        } else {
          showErrorAlert(response.message);
        }
      },
      error: (xhr, status, error) => {
        // Handle errors here
        console.error(xhr.responseText); // Log the error response for debugging
        // You can display an error message or perform other actions here
        showErrorAlert("An error occurred while processing your request.");
      }
    });
  });
});


const showSuccessAlert = () => {
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
}

const showErrorAlert = (message) => {
  Swal.fire({
    icon: 'error',
    title: 'Lỗi!',
    text: message,
  });
}
