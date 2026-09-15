<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(32, $_SESSION['chucNang'])) {

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
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./assets/oneForAll.css" />
  <link rel="stylesheet" href="./assets/Admin.css" />
  <link rel="stylesheet" href="./assets/temp.css" />
  <link rel="stylesheet" href="./../../view/assets/css/oneForAll.css" />
  <link rel="stylesheet" href="./../../view/assets/css/Admin.css" />
  <link rel="stylesheet" href="./../../view/assets/css/temp.css" />
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
              <div>
                <div class="Manager_wrapper__vOYy">
                  <div class="Sidebar_sideBar__CC4MK">
                    <?php
                    echo loadPageDependOnFeature();
                    ?>
                  </div>
                  <div style="padding-left: 16%; width: 100%; padding-right: 2rem">
                    <div class="Admin_rightBar__RXnS9">
                      <div style="display: flex; margin-bottom: 1rem; align-items: center;">
                        <p class="Admin_title__1Tk48">Các nhóm quyền</p>
                        <?php if (checkFeatureExists(28)) {
                          echo '<button style="margin-left: auto; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem; border-radius: 0.6rem; cursor: pointer;"><a href="../AdminController/AdminIndex.php?page=addRole" >Thêm mới một nhóm quyền</a>
                        </button>';
                        }
                        ?>

                      </div>
                      <div class="Admin_boxFeature__ECXnm">
                        <div style="position: relative;">

                          <input type="text" id="timKiemQuyen" class="Admin_input__LtEE-" placeholder="Tìm kiếm nhóm quyền">
                        </div>

                      </div>
                      <div class="Admin_boxTable__hLXRJ">
                        <div id="pagination">

                          <?php
                          if ($Totalpages <= 1) {
                            echo '';
                          } else if ($Totalpages <= 4 && $Totalpages > 1) {
                            for ($i = 1; $i <= $Totalpages; $i++) {
                              if ($i == $currentpage) {
                                echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                              } else {
                                echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                              }
                            }
                          } else {
                            if ($currentpage == 1) {
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(1)">1</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(2)">2</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentpage == $Totalpages) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . ($Totalpages - 1) . ')">' . ($Totalpages - 1) . '</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentpage == 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(2)">2</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(3)">3</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentpage == $Totalpages - 1) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . ($Totalpages - 2) . ')">' . ($Totalpages - 2) . '</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(' . ($Totalpages - 1) . ')">' . ($Totalpages - 1) . '</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentpage == 3) {
                              for ($i = 1; $i <= 4; $i++) {
                                if ($i == $currentpage) {
                                  echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                } else {
                                  echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                }
                              }
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $Totalpages . ')">' . $Totalpages . '</button>';
                            } else if ($currentpage == $Totalpages - 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              for ($i = $Totalpages - 3; $i <= $Totalpages; $i++) {
                                if ($i == $currentpage) {
                                  echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                } else {
                                  echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                }
                              }
                            } else if ($currentpage > 3 && $currentpage < $Totalpages - 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              for ($i = $currentpage - 1; $i <= $currentpage + 1; $i++) {
                                if ($i == $currentpage) {
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
                              <th class="Table_th__hCkcg">Mã</th>
                              <th class="Table_th__hCkcg">Tên Quyền</th>

                              <th class="Table_th__hCkcg">Thao Tác</th>
                            </tr>
                          </thead>

                          <tbody id="Role_container">
                            <?php
                            $vitri = 0;
                            foreach ($Result as $record) {
                              $vitri++;
                              if ($vitri % 2 !== 0) {
                                echo '<tr>
                <td class="Table_data_quyen_1">' . $record['MaQuyen'] . '</td>
                <td class="Table_data_quyen_1">' . $record['TenQuyen'] . '</td>
                <td class="Table_data_quyen_1">';

                                // Kiểm tra nếu $record['MaQuyen'] không phải là 1, 2 hoặc 3 thì hiển thị nút Xóa
                                if ($record['TenQuyen'] !== "Admin" && $record['TenQuyen'] !== "User") {
                                  if (checkFeatureExists(30)) {
                                    echo '<button class="delete" onclick="deleteRole(' . $record['MaQuyen'] . ')">Xóa</button>';
                                  }
                                  if (checkFeatureExists(29)) {
                                    echo '<a class="edit" href="../AdminController/AdminIndex.php?page=ChinhSuaQuyen&id=' . $record['MaQuyen'] . '">Sửa</a>';
                                  } else {
                                  }
                                } else {
                                  echo "<p> Mặc định </p>";
                                }
                                echo '</td>
            </tr>';
                              } else {
                                echo '<tr>
                <td class="Table_data_quyen_2">' . $record['MaQuyen'] . '</td>
                <td class="Table_data_quyen_2">' . $record['TenQuyen'] . '</td>
                <td class="Table_data_quyen_2">';

                                // Kiểm tra nếu $record['MaQuyen'] không phải là 1, 2 hoặc 3 thì hiển thị nút Xóa
                                if ($record['TenQuyen'] !== "Admin" && $record['TenQuyen'] !== "User") {
                                  if (checkFeatureExists(30)) {
                                    echo '<button class="delete" onclick="deleteRole(' . $record['MaQuyen'] . ')">Xóa</button>';
                                  }
                                  if (checkFeatureExists(29)) {
                                    echo '<a class="edit" href="../AdminController/AdminIndex.php?page=ChinhSuaQuyen&id=' . $record['MaQuyen'] . '">Sửa</a>';
                                  }
                                } else {
                                  echo "<p> Mặc định </p>";
                                }
                                echo '</td>
            </tr>';
                              }
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
  document.getElementById("timKiemQuyen").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
      sendDataToServer();
    }
  })

  function sendDataToServer() {
    var inputText = document.getElementById("timKiemQuyen").value;
    var xhr = new XMLHttpRequest();
    var searchUrl = '../AdminController/AdminIndex.php?page=Role&search=' + encodeURIComponent(inputText) + "&numpage=1"; // Sử dụng encodeURIComponent để chắc chắn rằng các ký tự đặc biệt được mã hóa đúng cách
    console.log(searchUrl)
    xhr.open('GET', searchUrl, true);
    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
        var tempElement = document.createElement('div');
        tempElement.innerHTML = xhr.responseText;

        var newTbody = tempElement.querySelector('.Admin_boxTable__hLXRJ');
        var currentTbody = document.querySelector('.Admin_boxTable__hLXRJ');
        currentTbody.parentNode.replaceChild(newTbody, currentTbody);
      } else {
        console.error("Error: " + xhr.status);
      }
    };
    xhr.send();
  }

  function Pagination(value) {
    let search = document.getElementById("timKiemQuyen");
    let searchValue = search ? search.value : "";

    let link = "../AdminController/AdminIndex.php?page=Role&numpage=" + value;

    if (searchValue) {
      link += "&search=" + searchValue;
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

  function deleteRole(MaQuyen) {
    Swal.fire({
      title: "Bạn chắc chắn muốn xóa?",
      text: "Bạn sẽ không thể khôi phục lại dữ liệu!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Xóa!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Đã xóa!",
          text: "Bạn đã xóa thành công",
          icon: "success"
        });
        deleteRoleProcess(MaQuyen);
      }
    });
  }

  function deleteRoleProcess(MaQuyen) {
    let currentPageElement = document.getElementsByClassName('btn_current')[0];
    let currentPage = currentPageElement ? currentPageElement.textContent.trim() : 1;
    let valuesearch = document.getElementById('timKiemQuyen').value;
    // Tạo một đối tượng XMLHttpRequest

    var xhr = new XMLHttpRequest();

    // Tạo URL cho yêu cầu xóa role
    var deleteUrl = '../AdminController/AdminIndex.php?page=Role&action=delete&id=' + MaQuyen + "&search=" + valuesearch + "&numpage=" + currentPage;
    console.log(deleteUrl);
    // Mở kết nối

    xhr.open('GET', deleteUrl, true);
    console.log("Error: " + xhr.status);
    // Đặt callback cho sự kiện load
    xhr.onload = function() {
      console.log(xhr.responseText)
      // Kiểm tra xem yêu cầu thành công hay không
      if (xhr.status >= 200 && xhr.status < 300) {
        // console.log(xhr.responseText);
        // Tạo một đối tượng HTML để chứa nội dung trả về từ server
        var tempElement = document.createElement('div');
        tempElement.innerHTML = xhr.responseText;

        // Tìm phần tbody trong nội dung trả về và thay thế phần tbody hiện tại
        var newTbody = tempElement.querySelector('.Admin_boxTable__hLXRJ');
        var currentTbody = document.querySelector('.Admin_boxTable__hLXRJ');
        currentTbody.parentNode.replaceChild(newTbody, currentTbody);
      } else {
        // Xử lý lỗi nếu có
        console.error("Error: " + xhr.status);
      }
    };

    // Đặt callback cho sự kiện error
    xhr.onerror = function() {
      console.error("Error: Request failed");
    };

    // Gửi yêu cầu
    xhr.send();
  }
  document.querySelector('.StaffHeader_signOut__i2pcu').addEventListener('click', () => {
    // Redirect to the desired page
    window.location.href = '/UTH-PHP/src/controller/HomeController/HomeController.php'; // Replace 'https://example.com/new-page' with the URL of the page you want to redirect to
  });
</script>

</html>
