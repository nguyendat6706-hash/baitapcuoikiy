<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';

// Sử dụng biến $projectRoot để yêu cầu các file cần thiết
echo "$projectRoot/src/model/AccountModels/QuyenModel.php";
require_once "$projectRoot/src/model/AccountModels/QuyenModel.php";
require_once "$projectRoot/src/model/AccountModels/TaiKhoanModel.php";
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";
require_once "$projectRoot/src/controller/QuyenController/QuyenController.php";
require_once "$projectRoot/src/controller/QuyenController/PhanQuyenController.php";
require_once "$projectRoot/src/controller/AdminController/NguoiDungController.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
      case 'Role':
        $Data = new QuyenModel();
        if (!isset($_GET['search'])) {
          $response = $Data->getAllQuyenKhongPhanTrang("");
        } else {
          $value = $_GET['search'];
          $response = $Data->getAllQuyenKhongPhanTrang($value);
        }
        $Result = $response->data;
        require "../view/RoleView.php";
        break;
      case 'KiemTraRole':
        $Kiemtra = new QuyenController();
        if (isset($_GET['search'])) {
          $value = $_GET['search'];
          $Kiemtra->checkTenQuyen($value);
        }
        break;


      case 'User':
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        if (!is_null($action)) {
          switch ($action) {
            case "addAccount":
              require "../view/CreateAccount.php";
              break;

            case "blockOrUnblockAccount":
              $id = isset($_GET['id']) ? $_GET['id'] : null;
              $currentPage = isset($_GET['numPage']) ? $_GET['numPage'] : null;
              $search = isset($_GET['search']) ? $_GET['search'] : null;
              $state = isset($_GET['setstate']) ? $_GET['setstate'] : null;
              $Taikhoan = new TaiKhoanModel();
              $Taikhoan->BlockorUnblockTaiKhoan($id, $state);
              if (!$search) {
                $nextURL = "../controller/Index.php?page=User&numPage=" . $currentPage;
              } else {
                $nextURL = "../controller/Index.php?page=User&numPage=" . $currentPage . "&search=" . $search;
              }

              header("Location: $nextURL");
              // Xử lý khi xóa tài khoản
              break;
            case "updateAccount":
              // Xử lý khi cập nhật tài khoản
              $id = isset($_GET['id']) ? $_GET['id'] : null;
              $nguoiDung = new NguoiDungController();
              $nguoiDung->displayChiTietTaiKhoan($id);
              break;
            case "checkTaiKhoan":
              $tentaikhoan = isset($_GET['tenTaiKhoan']) ? $_GET['tenTaiKhoan'] : null;
              $nguoiDung = new TaiKhoanModel();
              $resp = $nguoiDung->checkTaiKhoanExits($tentaikhoan);
              if ($resp->status == 404) {
                echo 404;
              } else if ($resp->status == 200) {
                echo 200;
              }
              break;
            case "checkEmail":
              $email = isset($_GET['Email']) ? $_GET['Email'] : null;
              $nguoiDung = new NguoiDungModel();
              $resp = $nguoiDung->checkEmail($email);
              if ($resp->status == 404) {
                echo 404;
              } else if ($resp->status == 200) {
                echo 200;
              }
              break;
          }
        } else if (isset($_GET['numPage'])) {
          $currentPage = isset($_GET['numPage']) ? $_GET['numPage'] : null;
          $searchValue = isset($_GET['search']) ? $_GET['search'] : null;
          $filterValue = isset($_GET['idRole']) ? $_GET['idRole'] : null;
          // print_r( $currentPage);
          $sotrang = null;
          $danhsachtaikhoan = new NguoiDungModel();
          if (!$filterValue &&  $searchValue) {
            $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, $searchValue, "");
            if ($Res->status == 400) {
              $Ketqua = null;
            } else {
              $Ketqua = $Res->data;
              $sotrang = $danhsachtaikhoan->getRecordNguoiDung($searchValue, "")->totalPage;
            }
          } else if (!$searchValue && $filterValue) {
            $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, "", $filterValue);
            if ($Res->status == 400) {
              $Ketqua = null;
            } else {
              $Ketqua = $Res->data;
              $sotrang = $danhsachtaikhoan->getRecordNguoiDung("", $filterValue)->totalPage;
            }
          } else if ($searchValue && $filterValue) {
            $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, $searchValue, $filterValue);
            if ($Res->status == 400) {
              $Ketqua = null;
            } else {
              $Ketqua = $Res->data;
              $sotrang = $danhsachtaikhoan->getRecordNguoiDung($searchValue, $filterValue)->totalPage;
            }
          } else {
            $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, "", "");
            if ($Res->status == 400) {
              $Ketqua = null;
            } else {
              $Ketqua = $Res->data;
            }
            $sotrang = $danhsachtaikhoan->getRecordNguoiDung("", "")->totalPage;
          }
          require "$projectRoot\src/view\admin\user\UserView.php";
        } else {
          $redirect_url = "../controller/Index.php?page=User&numPage=1";
          header("Location: $redirect_url");
        }



      case 'suppliers':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!is_null($id)) {
          switch ($id) {
            case "addSupplier":
              require "../view/SupplierView.php";
              break;
            case "deleteSupplier":
              // Xử lý khi xóa nhà cung cấp
              break;
            case "updateSupplier":
              // Xử lý khi cập nhật nhà cung cấp
              break;
          }
        } else {
          // Xử lý khi không có id
        }
        break;

      case 'addRole':
        require "../view/DetailRole.php";
        break;
      case 'XoaQuyen':

        $id = (int)$_GET['id']; // Ép kiểu ID thành số nguyên
        $Quyen = new PhanQuyenController();
        $Quyen->XoaQuyen($id);
        $Data = new QuyenModel();
        $response = $Data->getAllQuyenKhongPhanTrang("");
        $Result = $response->data;
        require "../view/RoleView.php";
        break;

      case 'ChinhSuaQuyen':
        $id = (int)$_GET['id']; // Ép kiểu ID thành số nguyên
        $Quyen = new PhanQuyenController();
        $Quyen->displayChucNang($id);
        break;
    }
  } else {
    // Chuyển hướng người dùng đến trang 404 hoặc trang chính
    $redirect_url = "./Index.php?page=User&numPage=1";
    header("Location: $redirect_url");
  }
}




if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $DanhSachChucNang = [];
  $TenQuyen = "";

  if (isset($_POST['TenNhomQuyen'])) {
    $TenQuyen = $_POST['TenNhomQuyen'];
  }
  if (isset($_POST['QuanLyTaiKhoan'])) {
    foreach ($_POST['QuanLyTaiKhoan'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }

  if (isset($_POST['QuanLySanPham'])) {
    foreach ($_POST['QuanLySanPham'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }

  if (isset($_POST['QuanLyLoaiSanPham'])) {
    foreach ($_POST['QuanLyLoaiSanPham'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }

  if (isset($_POST['QuanLyNhaCungCap'])) {
    foreach ($_POST['QuanLyNhaCungCap'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }

  if (isset($_POST['QuanLySuKien'])) {
    foreach ($_POST['QuanLySuKien'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }

  if (isset($_POST['QuanLyPhieuNhapKho'])) {
    foreach ($_POST['QuanLyPhieuNhapKho'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }

  if (isset($_POST['QuanLyDonHang'])) {
    foreach ($_POST['QuanLyDonHang'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }
  // Ghi dữ liệu vào cơ sở dữ liệu hoặc thực hiện các thao tác khác với dữ liệu đã thu thập được.
  // Ví dụ:
  if ($_POST["action"] == "add_Role") {
    $Quyen = new QuyenModel();
    $Quyen->createQuyen($TenQuyen, $DanhSachChucNang);
    $Data = new QuyenModel();
    $response = $Data->getAllQuyen(1, "");
    $Result = $response->data;
    require "../view/RoleView.php";
  } else if ($_POST["action"] == "update_Role") {
    $MaQuyen = $_POST['MaQuyen'];
    $Data = new QuyenModel();
    $Data->updateQuyen($MaQuyen, $TenQuyen, $DanhSachChucNang);
    $response = $Data->getAllQuyen(1, "");
    $Result = $response->data;
    require "../view/RoleView.php";
  } else if ($_POST["action"] == "updateUser") {
    $Hoten = $_POST["HoTen"];
    $NgaySinh = $_POST["NgaySinh"];
    $DiaChi = $_POST["DiaChi"];
    $GioiTinh = $_POST["Gender"];
    $SoDienThoai = $_POST["Sdt"];
    $Email = $_POST["Email"];
    $Vaitro = $_POST["DoiTuong"];
    $MaTaiKhoan = $_POST["MaTaiKhoan"];
    $DoiTuong = $_POST["DoiTuong1"];
    $Update = new NguoiDungController();
    $Update->capNhatTaiKhoan($MaTaiKhoan, $Hoten, $NgaySinh, $GioiTinh, $SoDienThoai, $Email, $DiaChi, $Vaitro, $DoiTuong);
    $redirect_url = "../controller/Index.php?page=User&action=updateAccount&id=" . $MaTaiKhoan;
    header("Location: $redirect_url");
    exit();
  } else if ($_POST["action"] == "createUser") {
    $TenTaiKhoan = $_POST["HoTen"];
    $MatKhau = $_POST["password"];
    $MaQuyen = $_POST["DoiTuong"];
    $Hoten = $_POST["HoTen"];
    $NgaySinh = $_POST["NgaySinh"];
    $GioiTinh = $_POST["Gender"];
    $SoDienThoai = $_POST["Sdt"];
    $email = $_POST["Email"];
    $DiaChi = $_POST["DiaChi"];
    $DoiTuong = $_POST["DoiTuong1"];
    $create = new NguoiDungController();
    $create->createTaiKhoan($TenTaiKhoan, $MatKhau, $MaQuyen, $Hoten, $NgaySinh, $GioiTinh, $SoDienThoai, $email, $DiaChi, $DoiTuong);
    $redirect_url = "../controller/Index.php?page=User&numPage=1";
    header("Location: $redirect_url");
    exit();
  }
  // In dữ liệu dùng để kiểm tra
}
