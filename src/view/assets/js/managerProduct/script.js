let absolutePath;
let totalPages = 2;
let danhSachAnhAll = []; // Mảng chứa các ảnh (base64) đã chọn — dùng riêng cho form Tạo sản phẩm nhiều ảnh
$(document).ready(() => {
  // Function to handle setStatus button click
  $('.tableProduct').delegate(".setStatus", "click", (event) => {
    const maSanPham = $(event.currentTarget).attr('data-masanpham');

    // Show modal confirmation dialog
    showIntervention(() => {
      // Tạo đối tượng formData chứa dữ liệu cần gửi đi
      const formData = new FormData();
      formData.append('action', 'status');
      formData.append('MaSanPham', maSanPham);

      // Gửi request AJAX bằng axios
      $.ajax({
        url: '/UTH-PHP/src/controller/ProductController/ProductController.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
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
        error: function() {
          // Xử lý khi có lỗi xảy ra trong quá trình gửi request
          alert('Đã xảy ra lỗi trong quá trình cập nhật trạng thái');
        }
      });
    });
  });

  $('.tableProduct').delegate(".editProduct", "click", (event) => {
    // Lấy mã sản phẩm từ thuộc tính data-maSanPham của nút
    const maSanPham = $(event.currentTarget).attr('data-masanpham');

    // Chuyển hướng trang đến trang chỉnh sửa sản phẩm và truyền tham số maSanPham
    window.location.href = `/UTH-PHP/src/controller/ProductController/EditProductController.php?maSanPham=${maSanPham}`;
  });

  $('.btn__taoSanPham').click((event) => {
    // Chuyển hướng trang đến trang chỉnh sửa sản phẩm và truyền tham số maSanPham
    window.location.href = `/UTH-PHP/src/controller/ProductController/CreateProductController.php`;
  });


  // create
  $(".createProduct").on("submit", (event) => {
    event.preventDefault(); // Ngăn chặn hành động mặc định của form

    const formData = new FormData();
    formData.append('action', 'createProduct');

    // Kiểm tra phải chọn ít nhất 1 ảnh trước khi cho submit
    if (danhSachAnhAll.length === 0) {
      showErrorAlert("Vui lòng chọn ít nhất 1 ảnh cho sản phẩm");
      return;
    }

    // Gửi toàn bộ mảng ảnh base64 lên server, mỗi ảnh 1 dòng key "anhSanPham[]"
    // -> PHP sẽ tự gom thành mảng $_POST['anhSanPham']
    danhSachAnhAll.forEach((base64) => {
      formData.append('anhSanPham[]', base64);
    });

    // Lấy giá trị từ các trường input và thêm vào FormData
    $(".createProduct input").each(function() {
      formData.append($(this).attr('name'), $(this).val());
    });
    
    // Lấy giá trị từ select và thêm vào FormData
    formData.append('loaiSanPham', $('#loaiSanPham').val());

    $.ajax({
      url: "/UTH-PHP/src/controller/ProductController/CreateProductController.php", // URL đích
      type: "POST", // Phương thức
      data: formData, // Dữ liệu form
      processData: false, // Ngăn không xử lý dữ liệu
      contentType: false, // Ngăn không đặt kiểu dữ liệu
      success: (response) => {
        // Xử lý phản hồi thành công
        const responseJSON = JSON.parse(response);
        if (responseJSON.status === 200) {
          showSuccessAlert();
        } else {
          showErrorAlert(responseJSON.message);
        }
      },
      error: (xhr, status, error) => {
        // Xử lý lỗi
        console.error("Đã xảy ra lỗi:", error);
      }
    });

  });

  // Filter
  // Attach change event listener to input and select elements
  $('.boxFeature select, #searchInput').on('change', (event) => {
    // Call function to send selected values to the server
    getValue();
    console.log(activeFilters)
    activeFilters.pagination = 1;
    document.querySelector(".valuePage").innerText = 1;
    postRequestFilterByAjax();
  });

  // Attach click event listener to pagination buttons
  $('.paginationFilter button').on('click', (event) => {
    // Get the class of the clicked button
    const buttonClass = $(event.currentTarget).hasClass('prev') ? 'prev' : $(event.currentTarget).hasClass('next') ? 'next' : '';
    // Check if the clicked button is for previous or next page
    if (buttonClass === 'prev') {
      // Get the current page number
      let currentPage = parseInt($('.valuePage').text());

      // If the current page is already the first page, don't update the page
      if (currentPage === 1) return;

      // Calculate the new page number by subtracting 1
      const newPage = currentPage - 1;

      // Update the UI with the new page number
      $('.valuePage').text(newPage);

      activeFilters.pagination = newPage;
    } else if (buttonClass === 'next') {
      console.log("click")
      // Get the current page number and total number of pages
      let currentPage = parseInt($('.valuePage').text());
      // If the current page is already the last page, don't update the page
      if (currentPage === totalPages) return;

      // Calculate the new page number by adding 1
      const newPage = currentPage + 1;
      // Update the UI with the new page number
      $('.valuePage').text(newPage);
      activeFilters.pagination = newPage;
    }

    getValue();
    postRequestFilterByAjax();
  });


  // btn__cancel
  $('.btn__cancel').click((event) => {
    // Chuyển hướng trang đến trang chỉnh sửa sản phẩm và truyền tham số maSanPham
    window.location.href = `/UTH-PHP/src/controller/ProductController/ProductController.php`;
  });

  $(".updateProduct").on("submit", (event) => {
    event.preventDefault();
    // Tạo một đối tượng FormData từ form
    showIntervention(() => {
      const formData = new FormData();
      if (absolutePath !== undefined && absolutePath !== null && absolutePath !== "") {
        console.log(1);
        formData.append('AnhMinhHoa', absolutePath); // Đường dẫn tuyệt đối của ảnh
      } else {
        const img = $(event.currentTarget).find('img').attr('alt');
        console.log(img);
        formData.append('AnhMinhHoa', img)
      }
      $(".updateProduct input").each(function() {
        formData.append($(this).attr('name'), $(this).val());
      });
      formData.append('loaiSanPham', $('#loaiSanPham').val());
      const urlParams = new URLSearchParams(window.location.search);
      const maSanPham = urlParams.get('maSanPham');
      formData.append('maSanPham', maSanPham);
      formData.append('action', 'updateProduct');
      // Thực hiện AJAX request
      $.ajax({
        url: "/UTH-PHP/src/controller/ProductController/EditProductController.php",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: (response) => {
          const responseJSON = JSON.parse(response);
          if (responseJSON.status === 200) {
            showSuccessAlert();
          } else {
            showErrorAlert(responseJSON.message);
          }
        },
        error: (xhr, status, error) => {
          // Xử lý lỗi nếu có
          showErrorAlert("Đã xảy ra lỗi trong quá trình cập nhật sản phẩm");
        }
      });
    });
  });

  $('#uploadButton').click((event) => {
    // Tạo một input[type="file"]
    let input = document.createElement('input');
    input.type = 'file';

    // Bắt sự kiện change khi người dùng chọn ảnh
    input.addEventListener('change', function() {
      let file = this.files[0];
      if (file) {
        // absolutePath = file.webkitRelativePath || file.name;
        // console.log("Đường dẫn tuyệt đối của tệp ảnh: " + absolutePath);
        let reader = new FileReader();

        // Bắt sự kiện load khi đọc ảnh thành công
        reader.addEventListener('load', function() {
          // Hiển thị ảnh trên giao diện
          let image = document.createElement('img');
          image.src = reader.result;
          absolutePath = image.src;
          document.getElementById('imageContainer').innerHTML = '';
          document.getElementById('imageContainer').appendChild(image);

          // Thêm CSS cho ảnh
          let style = document.createElement('style');
          style.innerHTML = '#imageContainer img { width: 200px; height: 200px; object-fit: cover; }';
          document.head.appendChild(style);

        });

        // Đọc dữ liệu của file ảnh
        reader.readAsDataURL(file);
      }
    });

    // Kích hoạt sự kiện click cho input[type="file"]
    input.click();

  });

  $('#removeImage').click(() => {
    // Xóa hình ảnh khỏi phần tử có id là "imageContainer"
    document.getElementById('imageContainer').innerHTML = '';
    absolutePath = ""
  });

  // ============ XỬ LÝ CHỌN NHIỀU ẢNH (chỉ dùng cho trang Tạo sản phẩm) ============
  $('#anhSanPhamInputMulti').on('change', function() {
    const files = this.files;
    if (!files || files.length === 0) return;

    // Duyệt từng file được chọn, đọc thành base64 rồi đẩy vào mảng
    Array.from(files).forEach((file) => {
      const reader = new FileReader();
      reader.addEventListener('load', function() {
        danhSachAnhAll.push(reader.result); // reader.result là chuỗi base64 của ảnh
        renderPreviewAnhMulti();
      });
      reader.readAsDataURL(file);
    });

    // Reset input để lần sau chọn lại đúng file cũ vẫn bắn được sự kiện change
    this.value = '';
  });

  // Vẽ lại lưới ảnh preview dựa theo mảng danhSachAnhAll hiện tại
  function renderPreviewAnhMulti() {
    const container = document.getElementById('imageContainerMulti');
    container.innerHTML = '';

    danhSachAnhAll.forEach((base64, index) => {
      const wrapper = document.createElement('div');
      wrapper.style.cssText = 'position: relative; display: inline-block; margin: 4px;';

      const img = document.createElement('img');
      img.src = base64;
      img.style.cssText = 'width: 120px; height: 120px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc;';

      // Nút "x" gỡ riêng từng ảnh
      const btnRemove = document.createElement('button');
      btnRemove.type = 'button';
      btnRemove.innerText = 'x';
      btnRemove.style.cssText = 'position: absolute; top: 2px; right: 2px; background: rgba(0,0,0,0.6); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer;';
      btnRemove.addEventListener('click', () => {
        danhSachAnhAll.splice(index, 1); // xóa đúng ảnh bị bấm x
        renderPreviewAnhMulti(); // vẽ lại lưới sau khi xóa
      });

      wrapper.appendChild(img);
      wrapper.appendChild(btnRemove);
      container.appendChild(wrapper);
    });
  }

  // Nút gỡ toàn bộ ảnh đã chọn
  $('#removeImageMulti').click(() => {
    danhSachAnhAll = [];
    document.getElementById('imageContainerMulti').innerHTML = '';
  });

  // sort
  $('#sortPrice').click(() => {
    resetSortIcons()
    const sortUpIcon = 'Giá tiền <i class="fa-solid fa-caret-up"></i>';
    const sortDownIcon = 'Giá tiền <i class="fa-solid fa-caret-down"></i>';

    if (activeFilters.sort === "" || activeFilters.sort === "price_desc") {
      activeFilters.sort = "price_asc";
      $('#sortPrice').html(sortUpIcon);
    } else {
      activeFilters.sort = "price_desc";
      $('#sortPrice').html(sortDownIcon);
    }

    postRequestFilterByAjax();
  });



  $('#sortNameAsc').click(() => {
    resetSortIcons()
    const sortUpIcon = 'Tên Sản Phẩm <i class="fa-solid fa-caret-up"></i>';
    const sortDownIcon = 'Tên Sản Phẩm <i class="fa-solid fa-caret-down"></i>';
    if (activeFilters.sort === "" || activeFilters.sort === "name_desc") {
      activeFilters.sort = "name_asc";
      $('#sortNameAsc').html(sortUpIcon);
    } else {
      activeFilters.sort = "name_desc";
      $('#sortNameAsc').html(sortDownIcon);
    }

    postRequestFilterByAjax();
  });

  $('#sortIdAsc').click(() => {
    resetSortIcons()
    const sortUpIcon = 'ID <i class="fa-solid fa-caret-up"></i>';
    const sortDownIcon = 'ID <i class="fa-solid fa-caret-down"></i>';
    if (activeFilters.sort === "" || activeFilters.sort === "id_asc") {
      activeFilters.sort = "id_desc";
      $('#sortIdAsc').html(sortUpIcon);
    } else {
      activeFilters.sort = "id_asc";
      $('#sortIdAsc').html(sortDownIcon);
    }
    postRequestFilterByAjax();
  });

  $('#sortNongDo').click(() => {
    resetSortIcons()
    const sortUpIcon = 'Nồng Độ <i class="fa-solid fa-sort-up"></i>';
    const sortDownIcon = 'Nồng Độ <i class="fa-solid fa-caret-down"></i>';
    if (activeFilters.sort === "" || activeFilters.sort === "nongDo_desc") {
      activeFilters.sort = "nongDo_asc";
      $('#sortNongDo').html(sortUpIcon);
    } else {
      activeFilters.sort = "nongDo_desc";
      $('#sortNongDo').html(sortDownIcon);

    }
    postRequestFilterByAjax();
  });

  $('#sortDungTich').click(() => {
    resetSortIcons()
    const sortUpIcon = 'Dung Tích <i class="fa-solid fa-caret-up"></i>';
    const sortDownIcon = 'Dung Tích <i class="fa-solid fa-caret-down"></i>';
    if (activeFilters.sort === "" || activeFilters.sort === "theTich_desc") {
      activeFilters.sort = "theTich_asc";
      $('#sortDungTich').html(sortUpIcon);
    } else {
      activeFilters.sort = "theTich_desc";
      $('#sortDungTich').html(sortDownIcon);
    }
    postRequestFilterByAjax();
  });

  $('#sortSoLuongConLai').click(() => {
    resetSortIcons()
    const sortUpIcon = 'Số Lượng <i class="fa-solid fa-caret-up"></i>';
    const sortDownIcon = 'Số Lượng <i class="fa-solid fa-caret-down"></i>';
    if (activeFilters.sort === "" || activeFilters.sort === "soLuongConLai_DESC") {
      activeFilters.sort = "soLuongConLai_ASC";
      $('#sortSoLuongConLai').html(sortUpIcon);
    } else {
      activeFilters.sort = "soLuongConLai_DESC";
      $('#sortSoLuongConLai').html(sortDownIcon);
    }
    postRequestFilterByAjax();
  });

  $('#sortTrangThai').click(() => {
    resetSortIcons()
    const sortUpIcon = 'Trạng thái <i class="fa-solid fa-caret-up"></i>';
    const sortDownIcon = 'Trạng thái <i class="fa-solid fa-caret-down"></i>';
    if (activeFilters.sort === "" || activeFilters.sort === "trangThai_desc") {
      activeFilters.sort = "trangThai_asc";
      $('#sortTrangThai').html(sortUpIcon);
    } else {
      activeFilters.sort = "trangThai_desc";
      $('#sortTrangThai').html(sortDownIcon);
    }
    postRequestFilterByAjax();
  });
});



// Select the button and add a click event listener
document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
  // Redirect to the desired page
  window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
});

let activeFilters = {
  search: "",
  alcoholContent: "",
  volume: "",
  price: "",
  pagination: "",
  sort: ""
};

const getValue = () => {
  const alcoholContentFilter = $(".filter__nongDoCon").val();
  const priceFilter = $(".filter__price").val();
  const volumeFilter = $(".filter__theTich").val();

  activeFilters.alcoholContent = alcoholContentFilter === "default" ? "" : $(".filter__nongDoCon").val();
  activeFilters.volume = volumeFilter === "default" ? "" : $(".filter__theTich").val();
  activeFilters.price = priceFilter === "default" ? "" : $(".filter__price").val();
  activeFilters.search = $("#searchInput").val().trim();
};


const postRequestFilterByAjax = () => {
  const formData = new FormData();
  formData.append("action", "filter");
  helpPayLoadAjax(formData, {
    search: activeFilters.search,
    page: activeFilters.pagination,
    minGia: getValueGia(activeFilters.price).minGia,
    maxGia: getValueGia(activeFilters.price).maxGia,
    minNongDoCon: getNongDoCon(activeFilters.alcoholContent).minNongDoCon,
    maxNongDoCon: getNongDoCon(activeFilters.alcoholContent).maxNongDoCon,
    theTich: getValueTheTich(activeFilters.volume),
    sort: activeFilters.sort
  });

  $.ajax({
    url: "/UTH-PHP/src/controller/ProductController/ProductController.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: (response) => {
      console.log(response);
      if (response.pagination === 0 || response.pagination === 1 || response.pagination === null) {
        document.querySelector(".paginationFilter").style.display = "none";
      } else {
        document.querySelector(".paginationFilter").style.display = "flex";
      }

      if (response.products !== "<p>Không có sản phẩm phù hợp.</p>") {
        document.querySelector(".tableProduct").innerHTML = response.products;
        document.querySelector(".textMessage").innerHTML = "";
      } else {
        document.querySelector(".tableProduct").innerHTML = "";
        document.querySelector(".textMessage").innerHTML = response.products;
      }
      totalPages = (parseInt(response.pagination));
    },
    error: (jqXHR, textStatus, errorThrown) => {
      console.error("Error:", errorThrown);
    },
  });
};

const helpPayLoadAjax = (formData, dataObject) => {
  // Duyệt qua các thuộc tính của đối tượng dataObject
  for (const [key, value] of Object.entries(dataObject)) {
    // Kiểm tra xem giá trị của thuộc tính có tồn tại không và có khác rỗng không
    if (value !== undefined && value !== "" && value !== null) {
      formData.append(key, value);
    } else {
      formData.append(key, "");
    }
  }
};

const getValueTheTich = (value) => {
  let theTich;
  switch (value) {
    case "below-500ml":
      theTich = 500;
      break;
    case "below-750ml":
      theTich = 750;
      break;
    case "below-1000ml":
      theTich = 1000;
      break;
    case "below-4500ml":
      theTich = 4500;
      break;
    default:
      theTich = null;
      break;
  }
  return theTich;
};

const getValueGia = (value) => {
  let minGia, maxGia;
  switch (value) {
    case "0-100":
      minGia = 0;
      maxGia = 100000;
      break;
    case "100-500":
      minGia = 100000;
      maxGia = 500000;
      break;
    case "500-1000":
      minGia = 500000;
      maxGia = 1000000;
      break;
    case "1000-2000":
      minGia = 1000000;
      maxGia = 2000000;
      break;
    case "2000-5000":
      minGia = 2000000;
      maxGia = 5000000;
      break;
    case "5000-8000":
      minGia = 5000000;
      maxGia = 8000000;
      break;
    case "8000-10000":
      minGia = 8000000;
      maxGia = 10000000;
      break;
    case "10000-13000":
      minGia = 10000000;
      maxGia = 13000000;
      break;
    case "13000-18000":
      minGia = 13000000;
      maxGia = 18000000;
      break;
    case "18000-25000":
      minGia = 18000000;
      maxGia = 25000000;
      break;
    case "above-25000":
      minGia = 25000000;
      maxGia = Infinity;
      break;
    default:
      minGia = null;
      maxGia = null;
      break;
  }
  return { minGia, maxGia };
};

const getNongDoCon = (value) => {
  let minNongDoCon, maxNongDoCon;
  switch (value) {
    case "0-20%":
      minNongDoCon = 0;
      maxNongDoCon = 20;
      break;
    case "20-40%":
      minNongDoCon = 20;
      maxNongDoCon = 40;
      break;
    case "40-60%":
      minNongDoCon = 40;
      maxNongDoCon = 60;
      break;
    case "above-60%":
      minNongDoCon = 60;
      maxNongDoCon = 100; // Assuming there's no upper limit
      break;
    default:
      minNongDoCon = null;
      maxNongDoCon = null;
      break;
  }
  return { minNongDoCon, maxNongDoCon };
};

const showSuccessAlert = () => {
  Swal.fire({
    icon: 'success',
    title: 'Thành công!',
    text: 'Xử lý thành công.',
  }).then((result) => {
    if (result.isConfirmed) {
      // Reload trang khi người dùng nhấn OK
      window.location.href = `/UTH-PHP/src/controller/ProductController/ProductController.php`;
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

// default icon
const resetSortIcons = () => {
  const defaultIcon = '<i class="fa-solid fa-caret-down"></i>'; // Đặt icon mặc định
  $('#sortPrice').html('Giá tiền ' + defaultIcon);
  $('#sortNameAsc').html('Tên Sản Phẩm ' + defaultIcon);
  $('#sortIdAsc').html('ID ' + defaultIcon);
  $('#sortNongDo').html('Nồng Độ ' + defaultIcon);
  $('#sortDungTich').html('Dung Tích ' + defaultIcon);
  $('#sortSoLuongConLai').html('Số Lượng ' + defaultIcon);
  $('#sortTrangThai').html('Trạng thái ' + defaultIcon);
}



