<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(18, $_SESSION['chucNang'])) {

  // Nếu không có, chuyển hướng đến trang khác
  header("Location: http://localhost/UTH-PHP/src/controller/HomeController/HomeController.php");
  exit; // Đảm bảo dừng kịp thời việc thực thi của script
}

// hàm kiểm tra xem chức năng có tồn tại theo mã ( nhớ kĩ mã chức năng trong db rồi truyền vào check nếu có thì giá trị là true và ngược lại )
function checkFeatureExists($featureID)
{
  // Kiểm tra xem $featureID có tồn tại trong mảng $_SESSION['chucNang'] không
  return in_array($featureID, $_SESSION['chucNang']);
}

function loadPageDependOnFeature()
{
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


function generatePaginationButtons($totalPages, $current)
{
  if ($totalPages > 1) {
    $htmlContent = "";
    $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(\'prev\')">&lt</button>';

    if ($totalPages < 7) {
      for ($i = 1; $i <= $totalPages; $i++) {
        if ($current === $i) {
          $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:black;color:white;font-size:14px;" onclick="updatePage(' . $i . ')">' . $i . '</button>';
        } else {
          $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(' . $i . ')">' . $i . '</button>';
        }
      }
    } else {
      // Logic for more than 6 pages
      $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(1)">1</button>';
      $htmlContent .= "<span>...</span>";

      if ($current < 4) {
        for ($i = 2; $i <= 4; $i++) {
          $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(' . $i . ')">' . $i . '</button>';
        }
        $htmlContent .= "<span>...</span>";
        $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(' . $totalPages . ')">' . $totalPages . '</button>';
      } elseif ($current < $totalPages - 2) {
        $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(1)">1</button>';
        $htmlContent .= "<span>...</span>";

        for ($i = $current - 1; $i <= $current + 1; $i++) {
          $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(' . $i . ')">' . $i . '</button>';
        }

        $htmlContent .= "<span>...</span>";
        $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(' . $totalPages . ')">' . $totalPages . '</button>';
      } else {
        $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(1)">1</button>';
        $htmlContent .= "<span>...</span>";

        for ($i = $totalPages - 3; $i <= $totalPages; $i++) {
          $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(' . $i . ')">' . $i . '</button>';
        }
      }
    }

    $htmlContent .= '<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(\'next\')">&gt</button>';
    return $htmlContent;
  }
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../public/template/frontEnd/Manager/AdminDemo.css" />
  <link rel="stylesheet" href="../../view/admin/ProductType/ProductType.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Loại Sản Phẩm</title>

</head>

<body>
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
                  <div class="Admin_rightBar__RXnS9">
                    <div style="
                          display: flex;
                          margin-bottom: 1rem;
                          align-items: center;
                          justify-content:space-between;
                        ">
                      <p class="Admin_title__1Tk48">Loại Sản Phẩm</p>
                      <a style="
                            margin-left: auto;
                            font-family: Arial;
                            font-size: 1.5rem;
                            font-weight: 700;
                            color: white;
                            background-color: rgb(50,50, 50);
                            padding: 1rem;
                            border-radius: 0.6rem;
                            cursor: pointer;" href="#" onclick="navigateToPage()">Tạo Loại Sản Phẩm</a>
                    </div>
                    <div class="Admin_boxFeature__ECXnm">
                      <div style="position: relative;">
                        <ion-icon name="search-outline" style="position:absolute;top:50%;left:2%;transform:translateY(-50%);"></ion-icon>
                        <input id="input" class="Admin_input__LtEE-" placeholder="Tìm kiếm loại sản phẩm">
                      </div>
                      <?php
                      echo '<div id="pagination">';
                      $data = $model->getAllTypeProduct(1, "");
                      echo generatePaginationButtons($data->totalPages, 1);
                      echo '</div>
                    </div>
                    <div class="Admin_boxTable__hLXRJ">
                      <table class="Table_table__BWPy">
                        <thead class="Table_head__FTUog">
                          <tr>
                            <th class="Table_th__hCkcg">Mã loại sản phẩm</th>
                            <th class="Table_th__hCkcg">Tên loại sản phẩm</th>
                            <th class="Table_th__hCkcg">Thao tác</th>
                          </tr>
                        </thead>
                        <tbody id="body">';
                      $counter = 0;
                      foreach ($data->data as $record) {
                        if ($counter % 2 !== 0) {
                          if ($record['MaLoaiSanPham'] === 1) {
                            echo '<tr>
                            <td style="background-color:rgb(180 180 180);">' . $record['MaLoaiSanPham'] . '</td>
                            <td style="background-color:rgb(180 180 180);">' . $record['TenLoaiSanPham'] . '</td>
                            <td style="background-color:rgb(180 180 180);">Mặc định</td>
                            </tr>';
                          } else {
                            echo '<tr>
                              <td style="background-color:rgb(180 180 180);">' . $record['MaLoaiSanPham'] . '</td>
                              <td style="background-color:rgb(180 180 180);">' . $record['TenLoaiSanPham'] . '</td>
                              <td style="background-color:rgb(180 180 180);">' .
                              '<button style="
                                margin-left: auto;
                                font-family: Arial;
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: white;
                                background-color: rgb(0 142 255);
                                padding: 1rem;
                                border-radius: 0.6rem;
                                cursor: pointer;" onclick="navigateToPage(' . $record['MaLoaiSanPham'] . ',`' . $record['TenLoaiSanPham'] . '`)"
                                >Sửa</button>
                                <button style="
                                margin-left: auto;
                                  font-family: Arial;
                                  font-size: 1.5rem;
                                  font-weight: 700;
                                  color: white;
                                  background-color: rgb(255,0, 0);
                                  padding: 1rem;
                                  border-radius: 0.6rem;
                                  cursor: pointer;" onclick="deleteProductType(' . $record['MaLoaiSanPham'] . ')">Xóa</button>'
                              . '</td>
                              </tr>';
                          }
                        } else {
                          if ($record['MaLoaiSanPham'] === 1) {
                            echo '<tr>
                            <td class="Table_data_quyen_2">' . $record['MaLoaiSanPham'] . '</td>
                            <td class="Table_data_quyen_2">' . $record['TenLoaiSanPham'] . '</td>
                            <td class="Table_data_quyen_2">Mặc định</td>
                            </tr>';
                          } else {
                            echo '<tr>
                              <td class="Table_data_quyen_2">' . $record['MaLoaiSanPham'] . '</td>
                              <td class="Table_data_quyen_2">' . $record['TenLoaiSanPham'] . '</td>
                              <td class="Table_data_quyen_2">' .
                              '<button style="
                              margin-left: auto;
                              font-family: Arial;
                              font-size: 1.5rem;
                              font-weight: 700;
                              color: white;
                              background-color: rgb(0 142 255);
                              padding: 1rem;
                              border-radius: 0.6rem;
                              cursor: pointer;"  onclick="navigateToPage(' . $record['MaLoaiSanPham'] . ',`' . $record['TenLoaiSanPham'] . '`)"
                              >Sửa</button>
                              <button style="
                                margin-left: auto;
                                  font-family: Arial;
                                  font-size: 1.5rem;
                                  font-weight: 700;
                                  color: white;
                                  background-color: rgb(255,0, 0);
                                  padding: 1rem;
                                  border-radius: 0.6rem;
                                  cursor: pointer;" onclick="deleteProductType(' . $record['MaLoaiSanPham'] . ')">Xóa</button>'

                              . '</td>
                      </tr>';
                          }
                        }
                        $counter++;
                      }
                      ?>
                      </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal" style="height:auto;">

  </div>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script>
    let current = 1;
    document.getElementById("input").addEventListener("input", () => {
      clearTimeout(this.timeout); // Corrected function name
      this.timeout = setTimeout(() => {
        getAllTypeProduct();
      }, 500);
    })

    function navigateToPage(id, name) {
      if (id && name) {
        window.location.href = `http://localhost/UTH-PHP/src/controller/ProductTypeController/ProductTypeAdjustController.php?id=${id}&name=${name}`
      } else {
        window.location.href = `http://localhost/UTH-PHP/src/controller/ProductTypeController/ProductTypeAdjustController.php`
      }
    }

    function openModal(message) {
      var messageBox = document.getElementById('modal');
      messageBox.innerHTML = message;
      // Hiển thị message box
      messageBox.style.top = "50px"; // Hiện message box từ trên xuống

      setTimeout(function() {
        messageBox.style.top = "-200px"; // Ẩn message box
      }, 2000);
    }

    function deleteProductType(id) {
      if (window.confirm("Xác nhận xóa loại sản phẩm ?")) {
        var hasFeature = <?php echo checkFeatureExists(13) ? 'true' : 'false'; ?>;
        if (!hasFeature) {
          openModal(`
                <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                <p style="margin-left:10px;">Không có quyền thực hiện chức năng này</p>
                `)
        } else {
          var xhr = new XMLHttpRequest();
          var url = '../../model/ProductTypeModel/LoaiSanPhamQuery/LoaiSanPhamModelQueryDelete.php?maloaisanpham=' + id;
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
                if (responseData.message.length > 50) {
                  openModal(`
                  <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                  <p style="margin-left:10px;">Xóa không thành công do có liên kết với một sản phẩm trước đó</p>
                  `)
                } else {
                  openModal(`
                  <i class="fas fa-times close-icon" style="color:red;width:18px;height:18px;"></i>
                  <p style="margin-left:10px;">${responseData.message}</p>
                  `)
                }
              }
              getAllTypeProduct()
            }
          };
          xhr.send();
        }
      }
    }

    function updatePage(currentPage) {
      const pag = document.getElementById("pagination")
      const childNodes = pag.childNodes;
      if (currentPage === "next") {
        if (current < childNodes[childNodes.length - 2].textContent) {
          current = current + 1;
        }
      } else if (currentPage === "prev") {
        if (current > 1) {
          current = current - 1;
        }
      } else {
        current = currentPage;
      }
      getAllTypeProduct()
    }

    function loadPage(totalPages) {
      if (totalPages > 1) {
        let htmlContent = ""
        htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage('prev')">&lt</button>`
        if (totalPages < 7) {
          for (let i = 1; i <= totalPages; i++) {
            if (current === i) {
              htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:black;color:white;font-size:14px;" onclick="updatePage(${i})">${i}</button>`
            } else {
              htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${i})">${i}</button>`
            }
          }
        } else {
          if (current < 4) {
            for (let i = 1; i <= 4; i++) {
              if (current === i) {
                htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:black;color:white;font-size:14px;" onclick="updatePage(${i})">${i}</button>`
              } else {
                htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${i})">${i}</button>`
              }
            }
            htmlContent += "<span>...</span>"
            htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${totalPages})">${totalPages}</button>`
          } else if (current < totalPages - 2) {
            htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${1})">${1}</button>`
            htmlContent += "<span>...</span>"
            for (let i = totalPages - 3; i <= totalPages; i++) {
              if (current === i) {
                htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:black;color:white;font-size:14px;"  onclick="updatePage(${i})">${i}</button>`
              } else {
                htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${i})">${i}</button>`
              }
            }
          } else {
            htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${1})">${1}</button>`
            htmlContent += "<span>...</span>"
            htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${current-1})">${current-1}</button>`
            htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:black;color:white;font-size:14px;" onclick="updatePage(${current})">${current}</button>`
            htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${current+1})">${current+1}</button>`
            htmlContent += "<span>...</span>"
            htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage(${totalPages})">${totalPages}</button>`
          }
        }
        htmlContent += `<button style="border-radius:100%;width:30px;height:30px;margin-right:3px;background-color:white;color:black;font-size:14px;" onclick="updatePage('next')">&gt</button>`
        document.getElementById("pagination").innerHTML = htmlContent
      }
    }

    function getAllTypeProduct() {
      var search = document.getElementById("input").value;
      var xhr = new XMLHttpRequest();
      var url = `../../model/ProductTypeModel/LoaiSanPhamQuery/LoaiSanPhamModelQuery.php?page=${current}&search=${search}`;
      xhr.open('GET', url, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var responseData = JSON.parse(xhr.responseText);
          loadPage(responseData.totalPages)
          document.getElementById("body").innerHTML = "";
          var htmlContent = "";
          if (responseData.data.length == 0) {
            if (current > 1) {
              updatePage(current - 1);
            } else {
              htmlContent = "<tr><td colspan='3'>Không tìm thấy dữ liệu</td></tr>";
            }
          } else {
            responseData.data.forEach(function(item, index) {
              if (index % 2 !== 0) {
                if (item.MaLoaiSanPham === 1) {
                  htmlContent += `<tr>
                                <td style="background-color:rgb(180 180 180);">${item.MaLoaiSanPham}</td>
                                <td style="background-color:rgb(180 180 180);">${item.TenLoaiSanPham}</td>
                                <td style="background-color:rgb(180 180 180);">Mặc định</td>
                                </tr>`
                } else {
                  htmlContent += `<tr>
                                <td style="background-color:rgb(180 180 180);">${item.MaLoaiSanPham}</td>
                                <td style="background-color:rgb(180 180 180);">${item.TenLoaiSanPham}</td>
                                <td style="background-color:rgb(180 180 180);">
                                <button style="
                                margin-left: auto;
                                font-family: Arial;
                                font-size: 1.5rem;
                                font-weight: 700;
                                color: white;
                                background-color: rgb(0 142 255);
                                padding: 1rem;
                                border-radius: 0.6rem;
                                cursor: pointer;" onclick="navigateToPage(${item.MaLoaiSanPham},'${item.TenLoaiSanPham}')">Sửa</button>
                                    <button onclick="deleteProductType('${item.MaLoaiSanPham}')" style="
                                        margin-left: auto;
                                        font-family: Arial;
                                        font-size: 1.5rem;
                                        font-weight: 700;
                                        color: white;
                                        background-color: rgb(255,0, 0);
                                        padding: 1rem;
                                        border-radius: 0.6rem;
                                        cursor: pointer;">Xóa</button>
                                </td>
                            </tr>`;
                }
              } else {
                if (item.MaLoaiSanPham === 1) {
                  htmlContent += `<tr>
                                <td class="Table_data_quyen_2"">${item.MaLoaiSanPham}</td>
                                <td class="Table_data_quyen_2"">${item.TenLoaiSanPham}</td>
                                <td class="Table_data_quyen_2"">Mặc định</td>
                                </tr>`
                } else {
                  htmlContent += `<tr>
                                <td class="Table_data_quyen_2">${item.MaLoaiSanPham}</td>
                                <td class="Table_data_quyen_2">${item.TenLoaiSanPham}</td>
                                <td class="Table_data_quyen_2"> 
                                <button style="
                                  margin-left: auto;
                                  font-family: Arial;
                                  font-size: 1.5rem;
                                  font-weight: 700;
                                  color: white;
                                  background-color: rgb(0 142 255);
                                  padding: 1rem;
                                  border-radius: 0.6rem;
                                cursor: pointer;" onclick="navigateToPage(${item.MaLoaiSanPham},'${item.TenLoaiSanPham}')">Sửa</button>
                                    <button onclick="deleteProductType('${item.MaLoaiSanPham}')" style="
                                        margin-left: auto;
                                        font-family: Arial;
                                        font-size: 1.5rem;
                                        font-weight: 700;
                                        color: white;
                                        background-color: rgb(255,0, 0);
                                        padding: 1rem;
                                        border-radius: 0.6rem;
                                        cursor: pointer;">Xóa</button>
                                </td>
                            </tr>`;
                }
              }
            });
          }
          document.getElementById("body").innerHTML = htmlContent;
        }
      };
      xhr.send();
    }

    document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
      // Redirect to the desired page
      window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
    });
  </script>
</body>


</html>