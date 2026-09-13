const menu = document.querySelector(".menu");
const menuMain = menu.querySelector(".menu-main");
const goBack = menu.querySelector(".go-back");
const menuTrigger = document.querySelector(".mobile-menu-trigger");
const closeMenu = menu.querySelector(".mobile-menu-close");

menuMain.addEventListener("click", (e) => {
  if (!menu.classList.contains("active")) {
    return;
  }
  if (e.target.closest(".menu-item-has-children")) {
    const hasChildren = e.target.closest(".menu-item-has-children");
    showSubMenu(hasChildren);
  }
});
goBack.addEventListener("click", () => {
  hideSubMenu();
});
menuTrigger.addEventListener("click", () => {
  toggleMenu();
});
closeMenu.addEventListener("click", () => {
  toggleMenu();
});
document.querySelector(".menu-overlay").addEventListener("click", () => {
  toggleMenu();
});
const toggleMenu = () => {
  menu.classList.toggle("active");
  document.querySelector(".menu-overlay").classList.toggle("active");
}
function showSubMenu(hasChildren) {
  subMenu = hasChildren.querySelector(".sub-menu");
  subMenu.classList.add("active");
  subMenu.style.animation = "slideLeft 0.5s ease forwards";
  const menuTitle =
    hasChildren.querySelector("i").parentNode.childNodes[0].textContent;
  menu.querySelector(".mobile-menu-head").classList.add("active");
}

function hideSubMenu() {
  subMenu.style.animation = "slideRight 0.5s ease forwards";
  setTimeout(() => {
    subMenu.classList.remove("active");
  }, 300);
  menu.querySelector(".current-menu-title").innerHTML = "";
  menu.querySelector(".mobile-menu-head").classList.remove("active");
}

window.onresize = function() {
  if (this.innerWidth > 991) {
    if (menu.classList.contains("active")) {
      toggleMenu();
    }
  }
};

// obj filter
let activeFilters = {
  search: "",
  origin: "",
  brand: "",
  alcoholContent: "",
  volume: "",
  price: "",
  maLoaiSanPham: "",
  pagination: "",
};


$(document).ready(() => {
  // Sử dụng sự kiện "delegate" để xử lý sự kiện click trên các phần tử con của ".pagination-style-three"
  // pagination
  $(".pagination-style-three").on("click", "a", (event) => {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a
    const $clickedPage = $(event.target); // Lấy thẻ <a> mà người dùng đã nhấp vào
    const pageValue = $clickedPage.text().trim(); // Lấy nội dung của thẻ <a> (số trang)
    // Kiểm tra xem trang được nhấp có phải là trang "Prev" hoặc "Next" không
    activeFilters.pagination = +pageValue;
    postRequestFilterByAjax();
  }
  );

  // mã loại sản phẩm
  $(".title-link").click((event) => {
    // Ngăn chặn hành vi mặc định của thẻ a
    event.preventDefault();
    // Lấy mã loại sản phẩm từ thuộc tính data-ma-loai
    const maLoaiSanPham = $(event.currentTarget).attr('data-maLoaiSanPham');

    if (maLoaiSanPham === "all") {
      activeFilters.maLoaiSanPham = "";
      activeFilters.price = "";
      activeFilters.origin = "";
      activeFilters.brand = "";
      activeFilters.alcoholContent = "";
      activeFilters.volume = "";
      activeFilters.search = "";
    } else {
      activeFilters.maLoaiSanPham = maLoaiSanPham;
    }

    activeFilters.pagination = 1;
    postRequestFilterByAjax();

    toggleMenu()
    $("html, body").animate({
      scrollTop: $("#product").offset().top
    });
  });

  // search và filter
  $('#controlFilterButton').click(() => {
    $('.filter').toggle(); // Toggle display of the filter section
  });

  $(".submitFilter").on("click", (event) => {
    event.preventDefault();
    getValue();
    activeFilters.pagination = 1;
    postRequestFilterByAjax();

    // Reset select elements to their default values
    $('.filter select').each(function() {
      $(this).val($(this).find('option[selected]').val());
    });

    document.querySelector(".modal-body input").value = "";

    activeFilters.search = "";
    activeFilters.pagination = 1;
  });

  $(".search-product-input").on("keypress", (event) => {
    if (event.key === "Enter") {
      console.log("enter");
      $(".modal").modal("hide");

      getValue();
      activeFilters.pagination = 1;
      postRequestFilterByAjax();
      document.querySelector(".search-product-input").value = "";
      $("html, body").animate({
        scrollTop: $("#product").offset().top
      });
    }
  });

  // detail product
  $('.products').delegate('.product-image', 'click', (event) => {
    event.preventDefault();
    console.log('click');
    const productId = $(event.currentTarget).attr('data-productId');

    $.ajax({
      url: '/UTH-PHP/src/controller/HomeController/HomeController.php',
      method: 'POST',
      data: { action: 'detailProduct', maSanPham: productId },
      success: function(response) {
        // Xử lý phản hồi từ máy chủ (nếu cần)
        console.log(response);
        const responseJson = JSON.parse(response);
        if (responseJson.status === 200) {
          // Chuyển hướng trang đến trang chi tiết sản phẩm
          window.location.href = `/UTH-PHP/src/controller/HomeController/DetailProductController.php?maSanPham=${productId}`;
        } else {
          // Hiển thị thông báo lỗi
          showErrorAlert(responseJson.message);
        }
        // Redirect hoặc hiển thị thông tin sản phẩm...
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Lỗi:", errorThrown);
      }
    });
  });
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
  // add to cart
  $('.products').delegate('.add-to-cart-btn', 'click', (event) => {
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: '/UTH-PHP/src/controller/cartControll/cartController.php',
      data: {
        action: 'addToCart',
        productId: $(event.currentTarget).attr('data-productId')
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
         showSuccessMessage('Thêm vào giỏ hàng thành công!');

        }

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
          // Kiểm tra nếu số lượng sản phẩm trong giỏ hàng lớn hơn 0
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
});
// get value for filter and search
const getValue = () => {
  const originFilter = $(".filter__origin select").val();
  const brandFilter = $(".filter__branch select").val();
  const alcoholContentFilter = $(".filter__nongDoCon select").val();
  const priceFilter = $(".filter__price select").val();
  const volumeFilter = $(".filter__theTich select").val();

  activeFilters.origin = originFilter === "default" ? "" : $(".filter__origin select option:selected").text().trim();
  activeFilters.brand = brandFilter === "default" ? "" : $(".filter__branch select option:selected").text().trim();
  activeFilters.alcoholContent = alcoholContentFilter === "default" ? "" : $(".filter__nongDoCon select option:selected").text().trim();
  activeFilters.volume = volumeFilter === "default" ? "" : $(".filter__theTich select option:selected").text().trim();
  activeFilters.price = priceFilter === "default" ? "" : $(".filter__price select option:selected").text().trim();
  activeFilters.search = $(".modal-body input").val().trim();
};

// handle value
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

// Sử dụng hàm helpPayLoadAjax để thêm dữ liệu vào FormData
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
    brand: activeFilters.brand,
    origin: activeFilters.origin,
    maLoaiSanPham: activeFilters.maLoaiSanPham,
  });
  console.log("success");
  $.ajax({
    url: "/UTH-PHP/src/controller/HomeController/HomeController.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      document.querySelector(".products").innerHTML = response.products;
      document.querySelector(".pagination-style-three").innerHTML =
        response.pagination;
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error("Error:", errorThrown);
    },
  });
};

// helper filter to switch fit value
const getValueTheTich = (value) => {
  let theTich;
  switch (value) {
    case "Dưới 500ml":
      theTich = 500;
      break;
    case "Dưới 750ml":
      theTich = 750;
      break;
    case "Dưới 1000ml":
      theTich = 1000;
      break;
    case "Dưới 4500ml":
      theTich = 4500;
      break;
    default:
      theTich = null; // Trả về null nếu không có giá trị phù hợp
      break;
  }
  return theTich;
};

const getValueGia = (value) => {
  let minGia, maxGia;
  switch (value) {
    case "Từ 0 đến 100 nghìn":
      minGia = 0;
      maxGia = 100000;
      break;
    case "Từ 100 nghìn đến 500 nghìn":
      minGia = 100000;
      maxGia = 500000;
      break;
    case "Từ 500 nghìn đến 1 triệu":
      minGia = 500000;
      maxGia = 1000000;
      break;
    case "Từ 1 triệu đến 2 triệu":
      minGia = 1000000;
      maxGia = 2000000;
      break;
    case "Từ 2 triệu đến 5 triệu":
      minGia = 2000000;
      maxGia = 5000000;
      break;
    case "Từ 5 triệu đến 8 triệu":
      minGia = 5000000;
      maxGia = 8000000;
      break;
    case "Từ 8 triệu đến 10 triệu":
      minGia = 8000000;
      maxGia = 10000000;
      break;
    case "Từ 10 triệu đến 13 triệu":
      minGia = 10000000;
      maxGia = 13000000;
      break;
    case "Từ 13 triệu đến 18 triệu":
      minGia = 13000000;
      maxGia = 18000000;
      break;
    case "Từ 18 triệu đến 25 triệu":
      minGia = 18000000;
      maxGia = 25000000;
      break;
    case "Trên 25 triệu":
      minGia = 25000000;
      maxGia = Infinity;
      break;
  }
  return { minGia, maxGia };
};

const getNongDoCon = (value) => {
  let minNongDoCon, maxNongDoCon;
  switch (value) {
    case "Dưới 20%":
      minNongDoCon = 0;
      maxNongDoCon = 20;
      break;
    case "20%-40%":
      minNongDoCon = 20;
      maxNongDoCon = 40;
      break;
    case "40%-60%":
      minNongDoCon = 40;
      maxNongDoCon = 60;
      break;
    case "Trên 60%":
      minNongDoCon = 60;
      maxNongDoCon = 100000000000000000000;
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
  });
}

const showErrorAlert = (message) => {
  Swal.fire({
    icon: 'error',
    title: 'Lỗi!',
    text: message,
  });
}
