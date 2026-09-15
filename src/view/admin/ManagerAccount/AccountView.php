<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(32, $_SESSION['chucNang'])) {

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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="./../../view/assets/css/Admin.css" />
  <link rel="stylesheet" href="./../../view/assets/css/oneForAll.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


  <title>Document</title>
<link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/admin-responsive.css?v=20260914">
  <script src="/UTH-PHP/src/view/assets/js/admin-responsive.js?v=20260914" defer></script>
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
                    <div class="Admin_rightBar__RXnS9">
                      <div style="display: flex; margin-bottom: 1rem; align-items: center;">
                        <p class="Admin_title__1Tk48">Tài Khoản</p>
                        <?php if (checkFeatureExists(3))
                          echo '<a href="../AdminController/AdminIndex.php?page=Account&action=addAccount" style="margin-left: auto; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem; border-radius: 0.6rem; cursor: pointer;">Tạo Tài Khoản </a>' ?>
                      </div>
                      <div class="Admin_boxFeature__ECXnm">
                        <div style="position: relative;">

                          <ion-icon name="search-outline" style="position:absolute;top:50%;left:2%;transform:translateY(-50%);"></ion-icon>
                          <input class="Admin_input__LtEE-" id="Admin_find_User" placeholder="Tìm kiếm tài khoản">
                        </div>
                        <p style="font-family: Arial, Helvetica, sans-serif;"> Quyền hạn</p>
                        <select id="doituongfilter" onchange="Filter()" style="height: 3rem; padding: 0.3rem;">
                          <option value="">Quyền Hạn : Tất Cả</option>
                          <?php
                          $NhomQuyen = new QuyenModel();
                          $Result = $NhomQuyen->getAllQuyenKhongPhanTrang("")->data;
                          foreach ($Result as $record) {
                            echo "<option value=" . $record["MaQuyen"] . ">" . $record["TenQuyen"] . "</option>";
                          }
                          ?>
                        </select>
                        <p style="font-family: Arial, Helvetica, sans-serif;">Trạng thái</p>
                        <select id="doituongfilter2" onchange="Filter()" style="height: 3rem; padding: 0.3rem;">
                          <option value="">Tất cả</option>
                          <option value="0">Ngừng hoạt động</option>
                          <option value="1">Hoạt động</option>
                        </select>
                      </div>
                      <div class="Admin_boxTable__hLXRJ">
                        <div id="pagination">

                          <?php
                          if ($Totalpages <= 1) {
                            echo '';
                          } else if ($Totalpages <= 4 && $Totalpages > 1) {
                            for ($i = 1; $i <= $Totalpages; $i++) {
                              if ($i == $currentPage) {
                                echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                              } else {
                                echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                              }
                            }
                          } else {
                            if ($currentPage == 1) {
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(1)">1</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(2)">2</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentPage == $Totalpages) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . ($Totalpages - 1) . ')">' . ($Totalpages - 1) . '</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentPage == 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(2)">2</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(3)">3</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentPage == $Totalpages - 1) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . ($Totalpages - 2) . ')">' . ($Totalpages - 2) . '</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(' . ($Totalpages - 1) . ')">' . ($Totalpages - 1) . '</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentPage == 3) {
                              for ($i = 1; $i <= 4; $i++) {
                                if ($i == $currentPage) {
                                  echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                } else {
                                  echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                }
                              }
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentPage == $Totalpages - 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              for ($i = $Totalpages - 3; $i <= $Totalpages; $i++) {
                                if ($i == $currentPage) {
                                  echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                } else {
                                  echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                }
                              }
                            } else if ($currentPage > 3 && $currentPage < $Totalpages - 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {
                                if ($i == $currentPage) {
                                  echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                } else {
                                  echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                }
                              }
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            }
                          }
                          ?>
                        </div>
                        <table class="Table_table__BWPy">
                          <thead class="Table_head__FTUog">
                            <tr>
                              <th class="Table_th__hCkcg">Mã Tài Khoản</th>
                              <th class="Table_th__hCkcg">Tên đăng nhập</th>
                              <th class="Table_th__hCkcg">Quyền</th>
                              <th class="Table_th__hCkcg">Trạng thái</th>
                              <th class="Table_th__hCkcg">Thao tác</th>
                            </tr>
                          </thead>
                          <tbody id="table_user">
                            <?php
                            if ($Ketqua) {
                              $vitri = 0;
                              foreach ($Ketqua as $record) {
                                $vitri++;
                                if ($vitri % 2 !== 0) {
                                  echo '<tr>
                <td class="Table_data_quyen_1" style="height:80px">' . $record['MaTaiKhoan'] . '</td>
                <td class="Table_data_quyen_1">' . $record['TenDangNhap'] . '</td>
                <td class="Table_data_quyen_1">' . $record['TenQuyen'] . '</td>
                <td class="Table_data_quyen_1">' . ($record['TrangThai'] == 0 ? '<p>đã khóa</p>' : '<p>Đang mở</p>') . '</td>
                <td class="Table_data_quyen_1">';
                                  if (checkFeatureExists(5) && $record['MaQuyen'] != 1) {
                                    echo ' <button class="' . ($record['TrangThai'] == 0 ? 'unblock' : 'block') . '" onclick="deleteUser(' . $record['MaTaiKhoan'] . ',this)">
                    ' . ($record['TrangThai'] == 0 ? 'Mở khóa' : 'Khóa') . '
                    </button>';
                                  }
                                  if (checkFeatureExists(4)) {
                                    echo '<a href="../AdminController/AdminIndex.php?page=Account&action=updateAccount&id=' . $record['MaTaiKhoan'] . '" class="edit">Sửa</a>' .
                                      ' </td>
                </tr>';
                                  }
                                } else {
                                  echo '<tr>
                <td class="Table_data_quyen_2" style="height:80px">' . $record['MaTaiKhoan'] . '</td>
                <td class="Table_data_quyen_2">' . $record['TenDangNhap'] . '</td>
                <td class="Table_data_quyen_2">' . $record['TenQuyen'] . '</td>
                <td class="Table_data_quyen_2">' . ($record['TrangThai'] == 0 ? '<p>đã khóa</p>' : '<p>Đang mở</p>') . '</td>
                <td class="Table_data_quyen_2">';
                                  if (checkFeatureExists(5) && $record['MaQuyen'] != 1) {
                                    echo ' <button class="' . ($record['TrangThai'] == 0 ? 'unblock' : 'block') . '" onclick="deleteUser(' . $record['MaTaiKhoan'] . ',this)">
                    ' . ($record['TrangThai'] == 0 ? 'Mở khóa' : 'Khóa') . '
                    </button>';
                                  }
                                  if (checkFeatureExists(4)) {
                                    echo '<a href="../AdminController/AdminIndex.php?page=Account&action=updateAccount&id=' . $record['MaTaiKhoan'] . '" class="edit">Sửa</a>' .
                                      ' </td>
                </tr>';
                                  }
                                }
                              }
                            } else {
                              echo '<tr><td colspan="6" class="Table_data_quyen_1">Người dùng trống</td></tr>';
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
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.getElementById("Admin_find_User").addEventListener('input', function(event) {
    clearTimeout(this.timeout)
    this.timeout = setTimeout(() => {
      sendDataToServer()
    }, 1000)
  })

  function sendDataToServer() {
    console.log(123132);
    var search = $('#Admin_find_User').val();
    var filter1 = $('#doituongfilter').val();
    var filter2 = $('#doituongfilter2').val();
    // var filter = document.getElementById("doiTuongFilter").value;
    var searchUrl = '../AdminController/AdminIndex.php?page=Account&search=' + search + '&numpage=1';
    if (filter1) {
      searchUrl += "&idRole=" + filter1;
    }
    if (filter2) {
      searchUrl += "&trangthai=" + filter2;
    }

    console.log(searchUrl)
    $.ajax({
      url: searchUrl,
      type: 'GET',
      success: function(data) {
        console.log(data)
        var tempElement = $('<div>').html(data);
        var newTbody = tempElement.find('.Admin_boxTable__hLXRJ').first();
        var currentTbody = $('.Admin_boxTable__hLXRJ').first();
        currentTbody.replaceWith(newTbody);

      },
      error: function(xhr, status, error) {
        console.error('Error: ' + xhr.status + ' - ' + error);
      }
    });
  }

  function Pagination(value) {
    let search = document.getElementById("Admin_find_User");
    let searchValue = search ? search.value : "";
    let filter1 = document.getElementById("doituongfilter");
    let filter2 = document.getElementById("doituongfilter2");


    let link = "../AdminController/AdminIndex.php?page=Account&numpage=" + value;

    if (searchValue) {
      link += "&search=" + searchValue;
    }

    if (filter1 !== "") { // Kiểm tra nếu filterValue không rỗng
      link += "&idRole=" + filter1.value;
    }
    if (filter2 !== "") { // Kiểm tra nếu filterValue không rỗng
      link += "&trangthai=" + filter2.value;
    }
    console.log(link);
    $.ajax({
      url: link,
      type: 'GET',
      success: function(data) {
        // console.log(data);
        var tempElement = $('<div>').html(data);
        var newTbody = tempElement.find('.Admin_boxTable__hLXRJ').first();
        var currentTbody = $('.Admin_boxTable__hLXRJ').first();
        currentTbody.replaceWith(newTbody);
      },
      error: function(xhr, status, error) {
        console.error('Error: ' + xhr.status + ' - ' + error);
      }
    });
  }

  function deleteUser(MaUser, element) {
    let filter1 = document.getElementById("doituongfilter");
    let filter2 = document.getElementById("doituongfilter2");
    console.log("da vao tk");

    if (element.textContent.trim() == "Khóa") {
      Swal.fire({
        title: "Bạn có muốn khóa tài khoản không?",

        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Khóa",
        imageHeight: 1500,
      }).then((result) => {
        if (result.isConfirmed) {
          proceedWithDelete(MaUser, filter1, filter2, element);
        }
      });
    } else {
      proceedWithDelete(MaUser, filter1, filter2, element);
    }
  }

  function proceedWithDelete(MaUser, filter1, filter2, element) {
    let currentPage = 1; // Default to page 1
    let currentButton = document.querySelector('.btn_current');
    if (currentButton) {
      currentPage = parseInt(currentButton.textContent) || 1;
    }

    let state = element.textContent.trim() == "Mở khóa" ? 1 : 0;
    if (state == 1) {
      Swal.fire({

        icon: "success",
        title: "Mở khóa tài khoản thành công",
        showConfirmButton: false,
        timer: 1500
      });
    } else {
      Swal.fire({
        icon: "success",
        title: "Khóa tài khoản thành công",
        showConfirmButton: false,
        timer: 1500
      });
    }
    let valuesearch = document.getElementById('Admin_find_User').value;
    let Url = "";
    if (valuesearch) {
      Url = '../AdminController/AdminIndex.php?page=Account&numpage=' + currentPage + '&action=blockOrUnblockAccount&id=' + MaUser + '&setstate=' + state + "&search=" + valuesearch;
    } else {
      Url = '../AdminController/AdminIndex.php?page=Account&numpage=' + currentPage + '&action=blockOrUnblockAccount&id=' + MaUser + '&setstate=' + state;
    }
    if (filter1 !== null && filter1.value) {
      Url += "&idRole=" + filter1.value;
    }
    if (filter2 !== null && filter2.value) {
      Url += "&trangthai=" + filter2.value;
    }
    console.log(Url);
    var xhr = new XMLHttpRequest();

    xhr.open('GET', Url, true);
    xhr.onload = () => {
      if (xhr.status >= 200 && xhr.status < 300) {
        var temp = document.createElement('div');
        temp.innerHTML = xhr.responseText;
        console.log(xhr.responseText);
        var newTableHTML = temp.querySelector('.Admin_boxTable__hLXRJ').outerHTML;
        var currentTable = document.querySelector('.Admin_boxTable__hLXRJ');
        if (currentTable && newTableHTML) {
          currentTable.outerHTML = newTableHTML;
        }
      } else {
        console.error('Yêu cầu xóa tài khoản không thành công: ' + xhr.status);
      }
    };
    xhr.send();
  }

  function Filter() {
    let filter1 = document.getElementById("doituongfilter");
    let filter2 = document.getElementById("doituongfilter2");
    search = document.getElementById("Admin_find_User").value;

    let link = "../AdminController/AdminIndex.php?page=Account&numpage=1";
    if (filter1) {
      link += "&idRole=" + filter1.value;
    }
    if (search) {
      link += "&search=" + search;
    }
    if (filter2) {
      link += "&trangthai=" + filter2.value;
    }
    console.log(link)
    $.ajax({
      url: link,
      type: 'GET',
      success: function(data) {
        var tempElement = $('<div>').html(data);
        var newTbody = tempElement.find('.Admin_boxTable__hLXRJ').first();
        var currentTbody = $('.Admin_boxTable__hLXRJ').first();
        currentTbody.replaceWith(newTbody);
      },
      error: function(xhr, status, error) {
        console.error('Error: ' + xhr.status + ' - ' + error);
      }
    });
  }

  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
