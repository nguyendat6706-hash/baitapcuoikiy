<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(11, $_SESSION['chucNang'])) {

  // Nếu không có, chuyển hướng đến trang khác
  header("Location: http://localhost/UTH-PHP/src/controller/HomeController/HomeController.php");
  exit; // Đảm bảo dừng kịp thời việc thực thi của script
}

// hàm kiểm tra xem chức năng có tồn tại theo mã ( nhớ kĩ mã chức năng trong db rồi truyền vào check nếu có thì giá trị là true và ngược lại )
function checkFeatureExists($featureID) {
  // Kiểm tra xem $featureID có tồn tại trong mảng $_SESSION['chucNang'] không
  return in_array($featureID, $_SESSION['chucNang']);
}

function loadPageDependOnFeature() {
  $feature = array_map('intval', $_SESSION['chucNang']);
  $htmlContent = "";
  for ($i = 0; $i < count($feature); $i++) {
    if ($feature[$i] === 2) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/AdminController/AdminIndex.php?page=Account">
      <span class="MenuItemSidebar_title__LLBtx">Tài Khoản</span>
    </a>';
    }
    if ($feature[$i] === 6) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ProductController/ProductController.php">
      <span class="MenuItemSidebar_title__LLBtx">Sản Phẩm</span>
    </a>';
    }
    if ($feature[$i] === 10) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ProductTypeController/ProductTypeController.php">
      <span class="MenuItemSidebar_title__LLBtx">Loại Sản Phẩm</span>
    </a>';
    }
    if ($feature[$i] === 14) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/SupplierController/SupplierController.php">
      <span class="MenuItemSidebar_title__LLBtx">Nhà Cung Cấp</span>
    </a>';
    }
    if ($feature[$i] === 18) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/InventoryController/InventoryController.php">
      <span class="MenuItemSidebar_title__LLBtx">Phiếu Nhập Kho</span>
    </a>';
    }
    if ($feature[$i] === 21) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/cartControll/ManagerDonHangController.php">
      <span class="MenuItemSidebar_title__LLBtx">Đơn Hàng</span>
    </a>';
    }
    if ($feature[$i] === 23) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ManagerController/NguoiDungController.php?page=User&numpage=1">
      <span class="MenuItemSidebar_title__LLBtx">Người Dùng</span>
    </a>';
    }
    if ($feature[$i] === 27) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/AdminController/AdminIndex.php?page=Role">
      <span class="MenuItemSidebar_title__LLBtx">Nhóm Quyền</span>
    </a>';
    }
    if ($feature[$i] === 31) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ThongKeController/ThongKeTongQuat.php">
      <span class="MenuItemSidebar_title__LLBtx">Thống kê tổng quát</span>
    </a>';
    }
    if ($feature[$i] === 32) {
      $htmlContent .= '<a class="MenuItemSidebar_menuItem__56b1m" style="font-family:Arial, Helvetica, sans-serif;" href="http://localhost/UTH-PHP/src/controller/ThongKeController/ThongKeDonHang.php">
      <span class="MenuItemSidebar_title__LLBtx">Thống kê đơn hàng</span>
    </a>';
    }
  }
  return $htmlContent;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../public/template/frontEnd/Manager/AdminDemo.css" />
  <link rel="stylesheet" href="../../public/template/frontEnd/Manager/productAdJust.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Document</title>
</head>

<body>
  <div id="root">
    <div>
      <div class="App">
        <div class="StaffLayout_wrapper__CegPk">
          <div class="StaffHeader_wrapper__IQw-U">
            <p class="StaffHeader_title__QxjW4">Dekanta</p>
            <button class="StaffHeader_signOut__i2pcu">
              <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right-from-bracket" class="svg-inline--fa fa-arrow-right-from-bracket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 2rem; height: 2rem; color: white">
                <path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"></path>
              </svg>
            </button>
          </div>
          <div>
            <div>
              <div class="Manager_wrapper__vOYy">
                <div class="Sidebar_sideBar__CC4MK">
                  <?php
                  echo loadPageDependOnFeature();
                  ?>
                </div>
                <div style="padding-left: 16%; width: 100%; padding-right: 2rem">
                  <div class="wrapper">
                    <div style="
                          display: flex;
                          padding-top: 1rem;
                          align-items: center;
                          gap: 1rem;
                          padding-bottom: 1rem;
                        "></div>
                    <div class="boxFeature">
                      <div>
                        <h2 style="font-size: 2.3rem">Loại Sản phẩm</h2>
                        <p style="font-size: 1.1rem; font-weight: 700">
                          Loại Sản Phẩm / Xem và chỉnh sửa
                        </p>
                      </div>
                      <div>
                        <a href="http://localhost/UTH-PHP/src/controller/ProductTypeController/ProductTypeController.php" style="
                              font-family: Arial;
                              font-size: 1.5rem;
                              font-weight: 700;
                              border: 1px solid rgb(140, 140, 140);
                              background-color: white;
                              color: rgb(80, 80, 80);
                              padding: 1rem 2rem 1rem 2rem;
                              border-radius: 0.6rem;
                              cursor: pointer;
                            ">
                          Hủy
                        </a>
                        <button onclick="submitProductType()" style="
                              margin-left: 1rem;
                              font-family: Arial;
                              font-size: 1.5rem;
                              font-weight: 700;
                              color: white;
                              background-color: rgb(65, 64, 64);
                              padding: 1rem 2rem 1rem 2rem;
                              border-radius: 0.6rem;
                              cursor: pointer;
                            ">
                          Lưu
                        </button>
                      </div>
                    </div>
                    <div class="boxTable">
                      <h2>Thông Tin Loại Sản Phẩm</h2>
                      <form style="
                            display: flex;
                            padding: 0rem 1rem 0rem 1rem;
                            justify-content: space-between;
                          ">
                        <div>
                          <div style="padding-left: 1rem;display: flex; gap: 2rem">
                            <?php
                            if (isset($_GET['id'])) {
                              $id = $_GET['id'];
                              $name = $_GET['name'];
                              // Xử lý nếu có tham số id
                              echo '<div>
                                  <p class="text">Mã Loại Sản Phẩm</p>
                                  <input class="input" id="maLoaiSanPham" style="width: 30rem;background-color:white;" disabled placeholder="Nhập Tên Sản Phẩm" name="MaSP" value="' . $id . '" />
                                  </div>      
                                  <div>
                                    <p class="text">Tên Loại Sản Phẩm</p>
                                    <input class="input" id="tenLoaiSanPham" style="width: 50rem" placeholder="Nhập Tên Sản Phẩm" name="TenSP" value="' . $name . '" />
                                  </div>';
                            } else {
                              echo "
                              <div>
                                <p class='text'>Tên Loại Sản Phẩm</p>
                                <input class='input' id='tenLoaiSanPham' style='width: 50rem' placeholder='Nhập Tên Sản Phẩm' name='TenSP' />
                              </div>     ";
                            }
                            ?>

                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="modal">

    </div>
</body>
<script>
  function openModal(message) {
    var messageBox = document.getElementById('modal');
    messageBox.innerHTML = message
    // Hiển thị message box
    messageBox.style.top = "50px"; // Hiện message box từ trên xuống
    setTimeout(function() {
      messageBox.style.top = "-200px"; // Ẩn message box
    }, 2000);
  }

  function submitProductType() {
    var check = document.getElementById("maLoaiSanPham")
    var id = (check !== null) ? check.value : null;
    var name = document.getElementById("tenLoaiSanPham").value
    if (id) {
      if (name) {
        let hasFeature = <?php echo checkFeatureExists(12) ? 'true' : 'false'; ?>;
        if (!hasFeature) {
          openModal(`
                    <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                    <p style="margin-left:10px;">Không có quyền thực hiện chức năng này</p>
                    `)
        } else {
          var xhr = new XMLHttpRequest();
          var url = `../../model/ProductTypeModel/LoaiSanPhamQuery/LoaiSanPhamModelQueryUpdate.php?maloaisanpham=${id}&tenloaisanpham=${name}`;
          xhr.open("GET", url, true);
          xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
              var responseData = JSON.parse(xhr.responseText);
              if (responseData.status === 200) {
                openModal(`
                  <i class="fas fa-check-circle icon" style="color:green;width:18px;height:18px;"></i>
                  <p style="margin-left:10px;">${responseData.message}</p>
                  `)
              } else {
                openModal(`
                  <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                  <p style="margin-left:10px;">${responseData.message.includes("Duplicate") ? "Tên loại sản phẩm không được trùng" : "Tên không hợp lý"}</p>
                  `)
              }

            }
          };
          xhr.send();
        }
      } else {
        openModal(`
                <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                <p style="margin-left:10px;">Tên loại sản phẩm không được để trống</p>
                `)
      }
    } else {
      let hasFeature = <?php echo checkFeatureExists(11) ? 'true' : 'false'; ?>;
      if (!hasFeature) {
        openModal(`
                    <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                    <p style="margin-left:10px;">Không có quyền thực hiện chức năng này</p>
                    `)
      } else {
        var xhr = new XMLHttpRequest();
        var url = '../../model/ProductTypeModel/LoaiSanPhamQuery/LoaiSanPhamModelQueryCreate.php?tenloaisanpham=' + name;
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            var responseData = JSON.parse(xhr.responseText);
            var messageBox = document.getElementById('modal');
            if (responseData.status === 200) {
              openModal(`
                  <i class="fas fa-check-circle icon" style="color:green;width:18px;height:18px;"></i>
                  <p style="margin-left:10px;">${responseData.message}</p>
                  `)
            } else {
              openModal(`
                  <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                  <p style="margin-left:10px;">${responseData.message.includes("Duplicate") ? "Tên loại sản phẩm không được trùng" : "Tên không hợp lý"}</p>
                  `)
            }
          }
        };
        xhr.send();
      }
    }
  }
  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
</script>

</html>
