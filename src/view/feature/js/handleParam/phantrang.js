console.log(1);
// Khai báo biến xhr ở ngoài hàm loadPage()
let xhr = new XMLHttpRequest();

document.addEventListener("DOMContentLoaded", function () {
  let pagination = document.getElementById("pagination");
  console.log(pagination);
  pagination.addEventListener("click", function (event) {
    event.preventDefault();
    let target = event.target;
    if (target.tagName.toLowerCase() === "a") {
      let page = target.getAttribute("data-page");
      if (page) {
        // Lấy giá trị MaLoaiSanPham từ cookie
        let searchMaLoaiSanPhamValue = getMaLoaiSanPhamFromCookie();
        loadPage(page, searchMaLoaiSanPhamValue);
      }
    }
  });

  // Hàm để lấy giá trị MaLoaiSanPham từ cookie
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
});

function loadPage(page, searchMaLoaiSanPhamValue) {
  // Lấy giá trị của các trường input tìm kiếm
  let searchInputValue = document.querySelector(".search-input").value.trim();
  let searchBrandValue = document.querySelector(".searchthuongHieu").value;
  let searchMinCostValue = document.querySelector(".searchMinCost").value;
  let searchMaxCostValue = document.querySelector(".searchMaxCost").value;
  let searchMinTheTichValue = document.querySelector(".searchMinTheTich").value;
  let searchMaxTheTichValue = document.querySelector(".searchMaxTheTich").value;
  let searchMinAlcoholValue = document.querySelector(".searchMinAlcohol").value;
  let searchMaxAlcoholValue = document.querySelector(".searchMaxAlcohol").value;

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
    page;

  console.log("URL tìm kiếm:", searchURL);
  xhr.open("GET", searchURL, true);
  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
      let response = xhr.responseText;
      let parser = new DOMParser();
      let htmlDoc = parser.parseFromString(response, "text/html");
      let productHtml = htmlDoc.querySelector("#product").innerHTML;
      document.getElementById("product").innerHTML = productHtml;
    } else {
      console.error(xhr.statusText);
    }
  };
  xhr.onerror = function () {
    console.error("Có lỗi xảy ra trong quá trình gửi yêu cầu.");
  };
  xhr.send();
}
