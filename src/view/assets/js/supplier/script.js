$(document).ready(() => {
  const showIntervention = (callback) => {
    Swal.fire({
      title: 'Bạn có xác nhận hành động không ?',
      showCancelButton: true,
      confirmButtonText: 'Có',
      cancelButtonText: 'Không',
      icon: 'warning'
    }).then((result) => {
      if (result.isConfirmed) {
        callback();
      }
    });
  }

  const showSuccessAlert = () => {
    Swal.fire({
      icon: 'success',
      title: 'Thành công!',
      text: 'Xử lý thành công.',
    }).then((result) => {
      if (result.isConfirmed) {
        // Reload trang khi người dùng nhấn OK
        window.location.href = `/UTH-PHP/src/controller/SupplierController/SupplierController.php`;
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

  $('.createSupplierButton').on("click", () => {
    // Make an AJAX request to switch the URL to createSupplier
    console.log('Create Supplier');
    let form = new FormData();
    form.append('action', 'createSupplier');
    $.ajax({
      url: '/UTH-PHP/src/controller/SupplierController/SupplierController.php', // Change the URL to your desired endpoint
      type: 'POST', // Use POST method since FormData is used
      data: form, // Pass FormData object as data
      processData: false, // Prevent jQuery from automatically processing the data
      contentType: false, // Prevent jQuery from automatically setting the content type
      dataType: 'json',
      success: (response) => {
        console.log('Response:', response);
        if (response.status === 200) {
          window.location.href = '/UTH-PHP/src/controller/SupplierController/CreateSupplierController.php';
        }
      },
      error: function(xhr, status, error) {
        // Handle error
        console.error('Error:', xhr.status, error);
      }
    });
  });

  // create supplier
  $('.createSupplierForm').submit((event) => {
    event.preventDefault(); // Prevent the default form submission

    // Create FormData object and append form data
    let formData = new FormData(event.currentTarget)
    let tenNhaCungCap = formData.get('TenNhaCungCap');
    let soDienThoai = formData.get('SoDienThoai');
    let email = formData.get('Email');
    formData.append('action', 'createSupplier');

    // Send AJAX request
    showIntervention(() => {
      $.ajax({
        url: '/UTH-PHP/src/controller/SupplierController/CreateSupplierController.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          if (response.status === 200) {
            showSuccessAlert();
          } else {
            showErrorAlert(response.message)
          }
        },
        error: function(xhr, status, error) {
          console.error('Error:', xhr.status, error);
          // Handle error here
        }
      });
    });
  });

  // update
  $('#tableSupplier').on("click", ".btn-update-supplier", (event) => {
    const maNhaCungCap = $(event.currentTarget).attr('data-maNhaCungCap');
    window.location.href = `/UTH-PHP/src/controller/SupplierController/UpdateSupplierController.php?maNhaCungCap=${maNhaCungCap}`;
  })

  $('.updateSupplierForm').submit((event) => {
    event.preventDefault(); // Prevent the default form submission

    const maNhaCungCap = $(event.currentTarget).attr('key');
    console.log('maNhaCungCap', maNhaCungCap);
    // Create FormData object and append form data
    let formData = new FormData(event.currentTarget)
    let tenNhaCungCap = formData.get('TenNhaCungCap');
    let soDienThoai = formData.get('SoDienThoai');
    let email = formData.get('Email');
    formData.append("maNhaCungCap", maNhaCungCap);

    formData.append('action', 'updateSupplier');

    showIntervention(() => {
      // Send AJAX request
      $.ajax({
        url: '/UTH-PHP/src/controller/SupplierController/UpdateSupplierController.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: (response) => {
          if (response.status === 200) {
            showSuccessAlert();
          } else {
            showErrorAlert(response.message)
          }
        },
        error: (xhr, status, error) => {
          console.error('Error:', xhr.status, error);
        }
      });
    });
  });

  // delete
  $('#tableSupplier').on("click", ".btn-delete-supplier", (event) => {
    console.log('Delete Supplier');
    const maNhaCungCap = $(event.currentTarget).attr('data-maNhaCungCap');
    showIntervention(() => {
      $.ajax({
        url: '/UTH-PHP/src/controller/SupplierController/SupplierController.php',
        type: 'POST',
        data: {
          action: 'deleteSupplier',
          maNhaCungCap: maNhaCungCap
        },
        dataType: 'json',
        success: (response) => {
          console.log('Response:', response);
          if (response.status === 200) {
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
        },
        error: (xhr, status, error) => {
          showErrorAlert('Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
      });
    });
  })

  // Xử lý sự kiện khi nội dung của ô input "#searchInput" thay đổi
  $('#searchInput').on('keypress', function(event) {
    // Kiểm tra xem phím được nhấn có phải là phím Enter không (keyCode của phím Enter là 13)
    if (event.keyCode === 13) {
      // Ngăn chặn hành động mặc định của phím Enter (như submit form)
      event.preventDefault();

      const searchValue = $(this).val();

      $.ajax({
        url: '/UTH-PHP/src/controller/SupplierController/SupplierController.php',
        type: 'POST',
        data: {
          search: searchValue,
          action: "filter"
        },
        success: function(response) {
          console.log('Success:', response);
          document.getElementById('tableSupplier').innerHTML = response;
        },
        error: function(xhr, status, error) {
          console.error('Error:', xhr.status, error);
        }
      });

    }
  });
})






