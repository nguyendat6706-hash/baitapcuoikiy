<?php
session_start();
// Kiểm tra xem session có chứa key 'chucNang' hay không
if (!isset($_SESSION['chucNang']) && in_array(23, $_SESSION['chucNang'])) {

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
  <link rel="stylesheet" href="./../../view/assets/css/oneForAll.css" />
  <link rel="stylesheet" href="./../../view/assets/css/Admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="/../../../view/assets/oneForAll.css" /> -->
  <!-- <link rel="stylesheet" href="./../view/assets/oneForAll.css" /> -->
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
                        <p class="Admin_title__1Tk48">Người dùng</p>
                        <?php if (checkFeatureExists(24))
                          echo '<a href="../ManagerController/NguoiDungController.php?page=User&action=addAccount" style="margin-left: auto; font-family: Arial; font-size: 1.5rem; font-weight: 700; color: white; background-color: rgb(65, 64, 64); padding: 1rem; border-radius: 0.6rem; cursor: pointer;">Tạo mới người dùng hệ thống
                        </a>'
                        ?>
                      </div>
                      <div class="Admin_boxFeature__ECXnm">
                        <div style="position: relative;">

                          <input class="Admin_input__LtEE-" id="Admin_find_User" placeholder="Tìm kiếm tên người dùng">


                        </div>
                        <p style=" font-family: Arial; font-size: 1.5rem; font-weight: 700; padding: 1rem; border-radius: 0.6rem;">Vai trò</p>
                        <select name="Doituong" id="doiTuongFilter">
                          <option value="" selected>Tất cả</option>
                          <option value="NhanVienKinhDoanh">NhanVienKinhDoanh</option>
                          <option value="KhachHang">KhachHang</option>
                          <option value="NhanVienKyThuat">NhanVienKyThuat</option>
                          <option value="QuanLy">QuanLy</option>
                          <option value="CEO">CEO</option>

                        </select>
                      </div>
                      <div class="Admin_boxTable__hLXRJ">
                        <div id="pagination">

                          <?php
                          if ($sotrang <= 1) {
                            echo '';
                          } else if ($sotrang <= 4 && $sotrang > 1) {
                            for ($i = 1; $i <= $sotrang; $i++) {
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
                              echo '<button class="btn-patigation" onclick="Pagination(' . $sotrang . ')">' . $sotrang . '</button>';
                            } else if ($currentPage == $sotrang) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . ($sotrang - 1) . ')">' . ($sotrang - 1) . '</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $sotrang . ')">' . $sotrang . '</button>';
                            } else if ($currentPage == 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(2)">2</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(3)">3</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $sotrang . ')">' . $sotrang . '</button>';
                            } else if ($currentPage == $sotrang - 1) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . ($sotrang - 2) . ')">' . ($sotrang - 2) . '</button>';
                              echo '<button class="btn_current btn-patigation" onclick="Pagination(' . ($sotrang - 1) . ')">' . ($sotrang - 1) . '</button>';
                              echo '<button class="btn-patigation" onclick="Pagination(' . $sotrang . ')">' . $sotrang . '</button>';
                            } else if ($currentPage == 3) {
                              for ($i = 1; $i <= 4; $i++) {
                                if ($i == $currentPage) {
                                  echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                } else {
                                  echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                }
                              }
                              echo "...";
                              echo '<button class="btn-patigation" onclick="Pagination(' . $sotrang . ')">' . $sotrang . '</button>';
                            } else if ($currentPage == $sotrang - 2) {
                              echo '<button class="btn-patigation" onclick="Pagination(1)">1</button>';
                              echo "...";
                              for ($i = $sotrang - 3; $i <= $sotrang; $i++) {
                                if ($i == $currentPage) {
                                  echo '<button class="btn_current btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                } else {
                                  echo '<button class="btn-patigation" onclick="Pagination(' . $i . ')">' . $i . '</button>';
                                }
                              }
                            } else if ($currentPage > 3 && $currentPage < $sotrang - 2) {
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
                              echo '<button class="btn-patigation" onclick="Pagination(' . $sotrang . ')">' . $sotrang . '</button>';
                            }
                          }
                          ?>
                        </div>
                        <table class="Table_table__BWPy" style="height:400px">
                          <thead class="Table_head__FTUog">
                            <tr>
                              <th class="Table_th__hCkcg">Mã</th>
                              <th class="Table_th__hCkcg">Họ tên</th>
                              <th class="Table_th__hCkcg">Email</th>
                              <th class="Table_th__hCkcg">Đối tượng</th>
                              <th class="Table_th__hCkcg">Thao Tác</th>
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
                    <td class="Table_data_quyen_1" style="height:80px">' . $record['MaNguoiDung'] . '</td>
                    <td class="Table_data_quyen_1">' . $record['HoTen'] . '</td>
                    <td class="Table_data_quyen_1">' . $record['Email'] . '</td>
                    <td class="Table_data_quyen_1">' . $record['DoiTuong'] . '</td>
                    <td class="Table_data_quyen_1">';
                                  if (checkFeatureExists(26)) {
                                    echo ($record['DoiTuong'] !== 'KhachHang') ? '<button class="delete" onclick="deleteUser(' . $record['MaNguoiDung'] . ')">Xóa</button>' : '';
                                  }
                                  if (checkFeatureExists(25)) {
                                    echo '<a href="../ManagerController/NguoiDungController.php?page=User&action=updateAccount&id=' . $record['MaNguoiDung'] . '" class="edit">Sửa</a>
                    </td>
                    
                </tr>';
                                  }
                                } else {
                                  echo '<tr>
                    <td class="Table_data_quyen_2" style="height:80px">' .  $record['MaNguoiDung'] . '</td>
                    <td class="Table_data_quyen_2">' . $record['HoTen'] . '</td>
                    <td class="Table_data_quyen_2">' . $record['Email'] . '</td>
                    <td class="Table_data_quyen_2">' . $record['DoiTuong'] . '</td>
                    <td class="Table_data_quyen_2">';
                                  if (checkFeatureExists(26)) {
                                    echo ($record['DoiTuong'] !== 'KhachHang') ? '<button class="delete" onclick="deleteUser(' . $record['MaNguoiDung'] . ')">Xóa</button>' : '';
                                  }
                                  if (checkFeatureExists(25)) {
                                    echo ' <a href="../ManagerController/NguoiDungController.php?page=User&action=updateAccount&id=' . $record['MaNguoiDung'] . '" class="edit">Sửa</a>
                    </td>
                    
                </tr>';
                                  }
                                }
                              }
                            } else {
                              echo '<tr> <td colspan="9" class="Table_data_quyen_1">Người dùng trống</td> <tr>';
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
  document.getElementById("doiTuongFilter").addEventListener('change', Filter);
  document.getElementById("Admin_find_User").addEventListener('input', function(event) {
    clearTimeout(this.timeout)
    this.timeout = setTimeout(() => {
      sendDataToServer()
    }, 1000)
  })

  function sendDataToServer() {
    console.log(123132);
    var search = $('#Admin_find_User').val();
    var filter = document.getElementById("doiTuongFilter").value;
    var searchUrl = '../ManagerController/NguoiDungController.php?page=User&search=' + search + '&numpage=1';
    if (filter) {
      searchUrl += "&DoiTuong=" + filter;
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



  function deleteUser(MaUser) {
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
        deleteUserProcess(MaUser);
      }
    });
  }

  function deleteUserProcess(MaUser) {

    let filter = document.getElementById("doituongfilter");
    let currentPageElement = document.getElementsByClassName('btn_current')[0];
    let currentPage = currentPageElement ? currentPageElement.textContent.trim() : 1;
    let valuesearch = document.getElementById('Admin_find_User').value;
    let Url = "";
    if (valuesearch) {
      Url = '../ManagerController/NguoiDungController.php?page=User&numpage=' + currentPage + '&action=deleteUser' + '&id=' + MaUser + "&search=" + valuesearch;
    } else {
      Url = '../ManagerController/NguoiDungController.php?page=User&numpage=' + currentPage + '&action=deleteUser' + '&id=' + MaUser;
    }
    if (filter) {
      Url += "&filter=" + filter.value
    }
    console.log(Url);
    var xhr = new XMLHttpRequest();


    xhr.open('GET', Url, true);
    xhr.onload = () => {
      if (xhr.status >= 200 && xhr.status < 300) {
        var temp = document.createElement('div');
        temp.innerHTML = xhr.responseText;
        console.log(xhr.responseText);
        // console.log(xhr.responseText);
        var newTableHTML = temp.querySelector('.Admin_boxTable__hLXRJ').outerHTML;
        console.log(xhr.responseText);
        var currentTable = document.getElementsByClassName('Admin_boxTable__hLXRJ')[0];
        if (currentTable && newTableHTML) {
          currentTable.outerHTML = newTableHTML;
        }
      } else {
        console.error('Yêu cầu xóa tài khoản không thành công: ' + xhr.status);
      }
    }
    xhr.send();
  }

  function Pagination(value) {
    search = document.getElementById("Admin_find_User").value;
    filter = document.getElementById("doiTuongFilter").value
    console.log(value);

    console.log(search);
    if (!search) {
      link = "../ManagerController/NguoiDungController.php?page=User&numpage=" + value;
    } else {
      link = "../ManagerController/NguoiDungController.php?page=User&numpage=" + value + "&search=" + search;
    }
    if (!filter) {
      link += "&DoiTuong=" + filter;
    }
    console.log(link);
    $.ajax({
      url: link,
      type: 'GET',
      success: function(data) {
        console.log(data);
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

  function Filter(value) {
    filter = document.getElementById("doiTuongFilter").value;
    search = document.getElementById("Admin_find_User").value;
    console.log(value);
    let link = "../ManagerController/NguoiDungController.php?page=User&numpage=1";
    if (filter) {
      link += "&DoiTuong=" + filter;
    }
    if (search) {
      link += "&search=" + search;
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

</html>
