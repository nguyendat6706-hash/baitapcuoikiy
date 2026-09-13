document.addEventListener("DOMContentLoaded", function () {
  // Kiểm tra và xóa cookie MaLoaiSanPham khi trang được load
  clearMaLoaiSanPhamCookie();

  addKeypressListener(".search-input");
  addKeypressListener(".thuongHieu");
  addKeypressListener(".searchMinCost");
  addKeypressListener(".searchMaxCost");
  addKeypressListener(".searchMinTheTich");
  addKeypressListener(".searchMaxTheTich");
  addKeypressListener(".searchMinAlcohol");
  addKeypressListener(".searchMaxAlcohol");

  function addKeypressListener(selector) {
    let element = document.querySelector(selector);
    if (element) {
      element.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
          event.preventDefault();
          console.log("Đã nhấn phím Enter.");
          let searchMaLoaiSanPhamValue = getMaLoaiSanPhamFromCookie();
          performSearch(searchMaLoaiSanPhamValue);
        }
      });
    }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelectorAll(".home-navigation-child")
    .forEach(function (element) {
      element.addEventListener("click", function (event) {
        event.preventDefault();
        let searchMaLoaiSanPhamValue =
          this.querySelector("a").getAttribute("data-MaLoaiSanPham");
        console.log(
          "Đã nhấn vào một nút xuất xứ với giá trị:",
          searchMaLoaiSanPhamValue,
        );
        // Lưu giá trị MaLoaiSanPham vào cookie và thực hiện tìm kiếm
        saveMaLoaiSanPhamToCookie(searchMaLoaiSanPhamValue);
        performSearch(searchMaLoaiSanPhamValue);
      });
    });
});

document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector(".submit-search")
    .addEventListener("click", function (event) {
      event.preventDefault();
      console.log("Đã nhấn nút Submit.");
      let searchMaLoaiSanPhamValue = getMaLoaiSanPhamFromCookie();
      console.log("Giá trị xuất xứ:", searchMaLoaiSanPhamValue);
      performSearch(searchMaLoaiSanPhamValue);
    });
});

// Hàm để lấy giá trị MaLoaiSanPham từ cookie hoặc giữ nguyên ''
function getMaLoaiSanPhamFromCookie() {
  let cookieArray = document.cookie.split("; ");
  for (let cookie of cookieArray) {
    let [name, value] = cookie.split("=");
    if (name === "MaLoaiSanPham") {
      return decodeURIComponent(value);
    }
  }
  return "";
}

// Hàm để lưu giá trị MaLoaiSanPham vào cookie
function saveMaLoaiSanPhamToCookie(MaLoaiSanPhamValue) {
  document.cookie = `MaLoaiSanPham=${encodeURIComponent(MaLoaiSanPhamValue)};path=/`;
}

// Hàm để kiểm tra và xóa cookie MaLoaiSanPham
function clearMaLoaiSanPhamCookie() {
  let MaLoaiSanPhamCookie = getCookie("MaLoaiSanPham");
  if (MaLoaiSanPhamCookie) {
    document.cookie =
      "MaLoaiSanPham=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }
}

// Hàm để lấy cookie theo tên
function getCookie(name) {
  let cookieArray = document.cookie.split("; ");
  for (let cookie of cookieArray) {
    let [cookieName, cookieValue] = cookie.split("=");
    if (cookieName === name) {
      return decodeURIComponent(cookieValue);
    }
  }
  return null;
}

// Hàm để lấy trang hiện tại từ URL
function getCurrentPage() {
  let urlParams = new URLSearchParams(window.location.search);
  let currentPage = urlParams.get("page");
  return currentPage ? currentPage : 1; // Nếu không có tham số "page" thì trả về trang 1
}

// Hàm để thực hiện tìm kiếm
function performSearch(searchMaLoaiSanPhamValue = "") {
  // Lấy giá trị của các trường input tìm kiếm
  let searchInputValue = document.querySelector(".search-input").value.trim();
  let searchBrandValue = document.querySelector(".searchthuongHieu").value;
  let searchMinCostValue = document.querySelector(".searchMinCost").value;
  let searchMaxCostValue = document.querySelector(".searchMaxCost").value;
  let searchMinTheTichValue = document.querySelector(".searchMinTheTich").value;
  let searchMaxTheTichValue = document.querySelector(".searchMaxTheTich").value;
  let searchMinAlcoholValue = document.querySelector(".searchMinAlcohol").value;
  let searchMaxAlcoholValue = document.querySelector(".searchMaxAlcohol").value;

  let currentPage = getCurrentPage(); // Lấy trang hiện tại từ URL

  // Tạo URL tìm kiếm
  let searchURL =
    "homepage.php?search=" +
    encodeURIComponent(searchInputValue) +
    "&brand=" +
    encodeURIComponent(searchBrandValue) +
    "&minGia=" +
    encodeURIComponent(searchMinCostValue) +
    "&maxGia=" +
    encodeURIComponent(searchMaxCostValue) +
    "&minTheTich=" +
    encodeURIComponent(searchMinTheTichValue) +
    "&maxTheTich=" +
    encodeURIComponent(searchMaxTheTichValue) +
    "&minNongDoCon=" +
    encodeURIComponent(searchMinAlcoholValue) +
    "&maxNongDoCon=" +
    encodeURIComponent(searchMaxAlcoholValue) +
    "&MaLoaiSanPham=" +
    encodeURIComponent(searchMaLoaiSanPhamValue) +
    "&page=" +
    currentPage;

  console.log("URL tìm kiếm:", searchURL);
  // Gửi yêu cầu AJAX để thực hiện tìm kiếm
  let xhr = new XMLHttpRequest();
  xhr.open("GET", searchURL, true);
  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
      // Xử lý kết quả tìm kiếm ở đây:
      let response = xhr.responseText;
      let parser = new DOMParser();
      let htmlDoc = parser.parseFromString(response, "text/html");
      console.log(htmlDoc);
      let productHtml = htmlDoc.querySelector("#product").innerHTML;
      document.getElementById("product").innerHTML = productHtml;

      // Kiểm tra xem phần tử có id là "pagination" tồn tại không
      let paginationElement = htmlDoc.querySelector(".flag-totalPages");
      if (paginationElement) {
        let paginationHtml = paginationElement.innerHTML;
        document.querySelector("#pagination").innerHTML = paginationHtml;
      } else {
        document.querySelector(".flag-totalPages").innerHTML = "";
      }
    } else {
      console.error("Đã xảy ra lỗi khi thực hiện tìm kiếm.");
    }
  };
  xhr.onerror = function () {
    console.error("Đã xảy ra lỗi kết nối.");
  };
  xhr.send();
}
