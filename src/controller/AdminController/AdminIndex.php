<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once($projectRoot . "/src/model/AccountModels/QuyenModel.php");
require_once($projectRoot . "/src/model/AccountModels/TaiKhoanModel.php");
require_once($projectRoot . "/src/model/AccountModels/NguoiDungModel.php");
require_once($projectRoot . "/src/controller/AdminController/QuyenController.php");
require_once($projectRoot . "/src/controller/AdminController/PhanQuyenController.php");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
      case 'Role':
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        if (!$action) {
          $Data = new QuyenModel();
          $currentpage = isset($_GET['numpage']) ? ($_GET['numpage']) : 1;
          $search = isset($_GET['search']) ? ($_GET['search']) : "";
          $response = $Data->getAllQuyen($currentpage, $search);
          $Totalpages =  $response->totalPages;
          $Result = $response->data;
          require $projectRoot . "/src/view/admin/ManageRole/RoleView.php";
          break;
        } else {
          switch ($action) {
            case 'delete':
              $id = (int)$_GET['id']; // Ép kiểu ID thành số nguyên
              $currentpage = isset($_GET['numpage']) ? ($_GET['numpage']) : 1;
              $search = isset($_GET['search']) ? ($_GET['search']) : "";
              $Quyen = new PhanQuyenController();
              
              $Quyen->XoaQuyen($id);
              $Data = new QuyenModel();
              $res =$Data->getAllQuyen($currentpage, $search);
              // print_r(isEmpty($Data->getAllQuyen($currentpage, $search)->data));
              if(empty($Data->getAllQuyen($currentpage, $search)->data) && $currentpage>1){
                $currentpage-=1;
              }
              $response = $Data->getAllQuyen($currentpage, $search);
              $Totalpages =  $response->totalPages;
              $Result = $response->data;
              require $projectRoot . "/src/view/admin/ManageRole/RoleView.php";
              break;
            case 'KiemTraRole':
              $Kiemtra = new QuyenController();
              if (isset($_GET['search'])) {
                $value = $_GET['search'];
                $Kiemtra->checkTenQuyen($value);
              }
              break;
            case 'ChinhSuaQuyen':
              $id = (int)$_GET['id']; // Ép kiểu ID thành số nguyên
              $Data = new PhanQuyenModel();
              $Quyen = new QuyenModel();
              $Res = $Data->getPhanQuyenByMaQuyen($id);
              $Danhsachchucnang = [];
              foreach ($Res->data as $temp) {
                array_push($Danhsachchucnang, $temp["MaChucNang"]);
              }
              $Ten = $Quyen->getQuyenById($id)->data["TenQuyen"];
              $IDQuyen =  $id;
              // print_r($IDQuyen);
              require_once $projectRoot . "/src/view/admin/ManageRole/DetailRoleReload.php";
              // print_r($Danhsachchucnang);
              // print_r($Ten);   

          }
        }


        // case 'User':
        //   $action = isset($_GET['action']) ? $_GET['action'] : null;
        //   if (!is_null($action)) {
        //     switch ($action) {
        //       case "addAccount":
        //         require $projectRoot ."/src/view/admin/ManagerAccount/CreateAccount.php";
        //         break;

        //       case "blockOrUnblockAccount":
        //         $id = isset($_GET['id']) ? $_GET['id'] : null;
        //         $currentPage = isset($_GET['numPage']) ? $_GET['numPage'] : null;
        //         $search = isset($_GET['search']) ? $_GET['search'] : null;
        //         $state = isset($_GET['setstate']) ? $_GET['setstate'] : null;
        //         $Taikhoan = new TaiKhoanModel();
        //         $Taikhoan->BlockorUnblockTaiKhoan($id, $state);
        //         if (!$search) {
        //           $nextURL = "../controller/AdminIndex.php?page=User&numPage=" . $currentPage;
        //         } else {
        //           $nextURL = "../controller/AdminIndex.php?page=User&numPage=" . $currentPage . "&search=" . $search;
        //         }

        //         header("Location: $nextURL");
        //         // Xử lý khi xóa tài khoản
        //         break;
        //       case "updateAccount":
        //         // Xử lý khi cập nhật tài khoản
        //         $id = isset($_GET['id']) ? $_GET['id'] : null;
        //         $nguoiDung = new NguoiDungController();
        //         $nguoiDung->displayChiTietTaiKhoan($id);
        //         break;
        //       case "checkTaiKhoan":
        //         $tentaikhoan = isset($_GET['tenTaiKhoan']) ? $_GET['tenTaiKhoan'] : null;
        //         $nguoiDung = new TaiKhoanModel();
        //         $resp = $nguoiDung->checkTaiKhoanExits($tentaikhoan);
        //         if ($resp->status == 404) {
        //           echo 404;
        //         } else if ($resp->status == 200) {
        //           echo 200;
        //         }
        //         break;
        //       case "checkEmail":
        //         $email = isset($_GET['Email']) ? $_GET['Email'] : null;
        //         $nguoiDung = new NguoiDungModel();
        //         $resp = $nguoiDung->checkEmail($email);
        //         if ($resp->status == 404) {
        //           echo 404;
        //         } else if ($resp->status == 200) {
        //           echo 200;
        //         }
        //         break;
        //     }
        //   } else if (isset($_GET['numPage'])) {
        //     $currentPage = isset($_GET['numPage']) ? $_GET['numPage'] : null;
        //     $searchValue = isset($_GET['search']) ? $_GET['search'] : null;
        //     $filterValue = isset($_GET['idRole']) ? $_GET['idRole'] : null;
        //     // print_r( $currentPage);
        //     $sotrang = null;
        //     $danhsachtaikhoan = new NguoiDungModel();
        //     if (!$filterValue &&  $searchValue) {
        //       $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, $searchValue, "");
        //       if ($Res->status == 400) {
        //         $Ketqua = null;
        //       } else {
        //         $Ketqua = $Res->data;
        //         $sotrang = $danhsachtaikhoan->getRecordNguoiDung($searchValue, "")->totalPage;
        //       }
        //     } else if (!$searchValue && $filterValue) {
        //       $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, "", $filterValue);
        //       if ($Res->status == 400) {
        //         $Ketqua = null;
        //       } else {
        //         $Ketqua = $Res->data;
        //         $sotrang = $danhsachtaikhoan->getRecordNguoiDung("", $filterValue)->totalPage;
        //       }
        //     } else if ($searchValue && $filterValue) {
        //       $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, $searchValue, $filterValue);
        //       if ($Res->status == 400) {
        //         $Ketqua = null;
        //       } else {
        //         $Ketqua = $Res->data;
        //         $sotrang = $danhsachtaikhoan->getRecordNguoiDung($searchValue, $filterValue)->totalPage;
        //       }
        //     } else {
        //       $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, "", "");
        //       if ($Res->status == 400) {
        //         $Ketqua = null;
        //       } else {
        //         $Ketqua = $Res->data;
        //       }
        //       $sotrang = $danhsachtaikhoan->getRecordNguoiDung("", "")->totalPage;
        //     }
        //     require $projectRoot ."/src/view/admin/user/UserView.php";
        //   } else {
        //     $redirect_url = $projectRoot ."src/controller/AdminIndex.php?page=User&numPage=1";
        //     header("Location: $redirect_url");
        //   }
        //   break;


      case 'Account':
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        if (!is_null($action)) {
          switch ($action) {
            case "addAccount":
              require $projectRoot . "/src/view/admin/ManagerAccount/CreateAccount.php";
              break;

            case "blockOrUnblockAccount":
              $id = isset($_GET['id']) ? $_GET['id'] : null;
        $currentPage = isset($_GET['numpage']) ? $_GET['numpage'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $state = isset($_GET['setstate']) ? $_GET['setstate'] : null;
        $filter = isset($_GET['idRole']) ? $_GET['idRole'] : "";
        $trangthai = isset($_GET['trangthai']) ? $_GET['trangthai'] : "";

$Taikhoan = new TaiKhoanModel();
$Taikhoan->BlockorUnblockTaiKhoan($id, $state);

$nextURL = "../AdminController/AdminIndex.php?page=Account&numpage=" . $currentPage;

// Thêm các tham số vào URL nếu chúng tồn tại và không rỗng
if ($search !== null && $search !== "") {
    $nextURL .= "&search=" . $search;
}

if ($filter !== "") {
    $nextURL .= "&idRole=" . $filter;
}

if ($trangthai !== "") {
    $nextURL .= "&trangthai=" . $trangthai;
}
              // print_r( $nextURL);
               header("Location: $nextURL");
              // // Xử lý khi xóa tài khoản
              break;
            case "updateAccount":
              // Xử lý khi cập nhật tài khoản
              $id = isset($_GET['id']) ? $_GET['id'] : null;
              $TaiKhoan = new TaiKhoanModel();
              $Object = $TaiKhoan->getTaiKhoanById($id);
              $DataNguoiDung = $Object->data[0];
              require_once $projectRoot . "/src/view/admin/ManagerAccount/UpdateAccountView.php";
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
        } else {
          $currentPage = isset($_GET['numpage']) ? (int)$_GET['numpage'] : 1; // Đảm bảo giá trị của $page là một số nguyên
          $search = isset($_GET['search']) ? $_GET['search'] : "";
          $filter =  isset($_GET['idRole']) ? $_GET['idRole'] : "";
          $trangthai =  isset($_GET['trangthai']) ? $_GET['trangthai'] : "";
          // print_r($trangthai);
          $Account = new TaiKhoanModel();
          $Object = $Account->getAllTaiKhoan($currentPage, $search, $filter,$trangthai);
          $Ketqua = $Object->data;
          $Totalpages =  $Object->totalPages;
          require $projectRoot . "/src/view/admin/ManagerAccount/AccountView.php";
          break;
        }

        break;
      case 'addRole':
        require $projectRoot . "/src/view/admin/ManageRole/DetailRole.php";

        break;
        // case 'XoaQuyen':

        //   $id = (int)$_GET['id']; // Ép kiểu ID thành số nguyên
        //   $Quyen = new PhanQuyenController();
        //   $Quyen->XoaQuyen($id);
        //   $Data = new QuyenModel();
        //   $response = $Data->getAllQuyenKhongPhanTrang("");
        //   $Result = $response->data;
        //   require $projectRoot ."/src/view/admin/ManageRole/RoleView.php";
        //   break;

      case 'ChinhSuaQuyen':
        $id = (int)$_GET['id']; // Ép kiểu ID thành số nguyên
        $Data = new PhanQuyenModel();
        $Quyen = new QuyenModel();
        $Res = $Data->getPhanQuyenByMaQuyen($id);
        $Danhsachchucnang = [];
        foreach ($Res->data as $temp) {
          array_push($Danhsachchucnang, $temp["MaChucNang"]);
        }
        $Ten = $Quyen->getQuyenById($id)->data["TenQuyen"];
        $IDQuyen =  $id;
        // print_r($IDQuyen);
        require_once $projectRoot . "/src/view/admin/ManageRole/DetailRoleReload.php";
        // print_r($Danhsachchucnang);
        // print_r($Ten);   

    }
  }
}
// Chuyển hướng người dùng đến trang 404 hoặc trang chính
// $redirect_url = $projectRoot ."/src/controller/AdminController/AdminIndex.php?page=Account";
// header("Location: $redirect_url");



// $redirect_url = $projectRoot ."/src/controller/AdminController/AdminIndex.php?page=Account";
// header("Location: $redirect_url");


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
  if (isset($_POST['QuanLyQuyen'])) {
    foreach ($_POST['QuanLyQuyen'] as $action) {
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
  if (isset($_POST['QuanLyNguoiDung'])) {
    foreach ($_POST['QuanLyNguoiDung'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }
  if (isset($_POST['ThongKe'])) {
    foreach ($_POST['ThongKe'] as $action) {
      $DanhSachChucNang[] = (int)$action;
    }
  }
  // Ghi dữ liệu vào cơ sở dữ liệu hoặc thực hiện các thao tác khác với dữ liệu đã thu thập được.
  // Ví dụ:
  if ($_POST["action"] == "add_Role") {
   
    $Quyen = new QuyenModel();
    $Quyen->createQuyen($TenQuyen, $DanhSachChucNang);
    $Data = new QuyenModel();
    $redirect_url = "../AdminController/AdminIndex.php?page=Role";
    header("Location: $redirect_url");
  } else if ($_POST["action"] == "update_Role") {
    $MaQuyen = $_POST['MaQuyen'];
    $Data = new QuyenModel();
    $Data->updateQuyen($MaQuyen, $TenQuyen, $DanhSachChucNang);
    $redirect_url = "../AdminController/AdminIndex.php?page=Role";
    header("Location: $redirect_url");
  } else if ($_POST["action"] == "updateAccount") {
    $TenTaiKhoan = $_POST["taikhoan"];
    $MatKhau = $_POST["password"];
    $MaQuyen = $_POST["DoiTuong"];
    $MaTaiKhoan = $_POST["MaTaiKhoan"];
    $create = new TaiKhoanModel();
    $create->updateTaiKhoanHeThong($MaTaiKhoan, $TenTaiKhoan, $MatKhau, $MaQuyen);
    $redirect_url = "../AdminController/AdminIndex.php?page=Account";
    header("Location: $redirect_url");
    exit();
  } else if ($_POST["action"] == "createAccount") {
    $TenTaiKhoan = $_POST["taikhoan"];
    $MatKhau = $_POST["password"];
    $MaQuyen = $_POST["DoiTuong"];
    $create = new TaiKhoanModel();
    $create->createTaiKhoanHeThong($TenTaiKhoan, $MatKhau, $MaQuyen);
    // print_r($create->createTaiKhoanHeThong($TenTaiKhoan,$MatKhau,$MaQuyen));
    $redirect_url = "../AdminController/AdminIndex.php?page=Account";
    header("Location: $redirect_url");
    exit();
  }
  // In dữ liệu dùng để kiểm tra
}
