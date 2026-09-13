<?php
ERROR_REPORTING(E_ALL);
ini_set('display_errors', 1);
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once($projectRoot . "/src/model/AccountModels/QuyenModel.php");
require_once($projectRoot . "/src/model/AccountModels/TaiKhoanModel.php");
require_once($projectRoot . "/src/model/AccountModels/NguoiDungModel.php");
require_once($projectRoot . "/src/controller/AdminController/QuyenController.php");
require_once($projectRoot . "/src/controller/AdminController/PhanQuyenController.php");
// require_once ($projectRoot . "/src/controller/AdminController/NguoiDungController.php");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
      case 'User':
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        if (!is_null($action)) {
          switch ($action) {
            case "addAccount":
              require $projectRoot . "/src/view/admin/user/CreateUserSystem.php";
              break;

            case "deleteUser":
              $id = isset($_GET['id']) ? $_GET['id'] : null;
              $currentPage = isset($_GET['numpage']) ? $_GET['numpage'] : 1;
              $search = isset($_GET['search']) ? $_GET['search'] : null;
              $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
              $NguoiDung = new NguoiDungModel();
              $NguoiDung->deleteNguoiDung($id);

              if ($NguoiDung->getFullNguoiDung($currentPage, $search, $filter)->status == 400 && $currentPage > 1) {
                $currentPage -= 1;
              }
              // print_r($NguoiDung->deleteNguoiDung($id)->message);
              if (!$search) {
                $nextURL = "../ManagerController/NguoiDungController.php?page=User&numpage=" . $currentPage;
              } else {
                $nextURL = "../ManagerController/NguoiDungController?page=User&numpage=" . $currentPage . "&search=" . $search;
              }
              if ($filter) {
                $nextURL += "&DoiTuong=" . $filter;
              }

              header("Location: $nextURL");
              // Xử lý khi xóa tài khoản
              break;

            case "GoTaiKhoan":
              $id = isset($_GET['id']) ? $_GET['id'] : null;
              $idTaiKhoan = isset($_GET['TaiKhoan']) ? $_GET['TaiKhoan'] : null;
              $TaiKhoan = new TaiKhoanModel();
              $TaiKhoan->setAllowTaiKhoan($idTaiKhoan, 1);
              $GoTaiKhoan = new NguoiDungModel();
              $GoTaiKhoan->GoTaiKhoan($id);
              print_r($GoTaiKhoan->GoTaiKhoan($id));
              $nextURL = "../ManagerController/NguoiDungController.php?page=User&action=updateAccount&id=" . $id;
              header("Location: $nextURL");
              break;
            case "updateAccount":
              // Xử lý khi cập nhật tài khoản
              $id = isset($_GET['id']) ? $_GET['id'] : null;
              $Hienthi = new NguoiDungModel();

              $Data = $Hienthi->getNguoiDungByMaTK($id);
              $HienthiTaiKhoan = new TaiKhoanModel();
              $Data2 = $HienthiTaiKhoan->HienThiDanhSachTaiKhoan();
              $DataTaiKhoan = $Data2->data;

              $DataNguoiDung = $Data->data;
              $TaiKhoan2 = new TaiKhoanModel();
              $idTaiKhoan = isset($DataNguoiDung["MaTaiKhoan"]) ? $DataNguoiDung["MaTaiKhoan"] : null;
              if ($idTaiKhoan) {
                $ThongTinTaiKhoanHienTai = $TaiKhoan2->getTaiKhoanById($idTaiKhoan)->data;
                //  print_r($ThongTinTaiKhoanHienTai[0]['MaTaiKhoan']);
              }

              require_once($projectRoot . "/src/view/admin/user/UpdateUserView.php");
              break;
              // case "checkTaiKhoan":
              //   $tentaikhoan = isset($_GET['tenTaiKhoan']) ? $_GET['tenTaiKhoan'] : null;
              //   $nguoiDung = new TaiKhoanModel();
              //   $resp = $nguoiDung->checkTaiKhoanExits($tentaikhoan);
              //   if ($resp->status == 404) {
              //     echo 404;
              //   } else if ($resp->status == 200) {
              //     echo 200;
              //   }
              //   break;
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
          $currentPage = isset($_GET['numpage']) ? $_GET['numpage'] : 1;
          $searchValue = isset($_GET['search']) ? $_GET['search'] : "";
          $filterValue = isset($_GET['DoiTuong']) ? $_GET['DoiTuong'] : "";
          // print_r( $currentPage);
          $sotrang = null;
          $danhsachtaikhoan = new NguoiDungModel();
          $Res = $danhsachtaikhoan->getFullNguoiDung($currentPage, $searchValue, $filterValue);
          if ($Res->status == 400) {
            $Ketqua = null;
          } else {
            $Ketqua = $Res->data;
            $sotrang = $danhsachtaikhoan->getRecordNguoiDung($searchValue, $filterValue)->totalPage;
          }

          require $projectRoot . "/src/view/admin/user/UserView.php";
          break;
        }
        break;
    }
  }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if ($_POST["action"] == "updateUser") {
    $MaTaiKhoan = $_POST["MaTaiKhoan"];
    $MaNguoiDung = $_POST["MaNguoiDung"];
    $TenTaiKhoan = $_POST["HoTen"];
    $NgaySinh = $_POST["NgaySinh"];
    $DiaChi = $_POST["DiaChi"];
    $GioiTinh = $_POST["Gender"];
    $Sdt = $_POST["Sdt"];
    $email = $_POST["Email"];
    $TaiKhoan = $_POST["TaiKhoan"];
    $DoiTuong = $_POST["DoiTuong"];
    // print_r('Tai khoan cu');
    // print_r($MaTaiKhoan);
    // print_r('Tai khoan moi');
    // print_r($TaiKhoan);
    // print_r($DoiTuong);

    if ($MaTaiKhoan) {
      $setState = new TaiKhoanModel();
      $setState->setAllowTaiKhoan($MaTaiKhoan, 1);
      // print_r($setState->setAllowTaiKhoan($MaTaiKhoan,1));
    }
    $update = new NguoiDungModel();
    $update->updateNguoiDung($MaNguoiDung, $TenTaiKhoan, $NgaySinh, $GioiTinh, $Sdt, $email, $DiaChi, $TaiKhoan, $DoiTuong);
    $setstate = new TaiKhoanModel();
    if ($TaiKhoan) {
      $setstate->setAllowTaiKhoan($TaiKhoan, 0);
    }
    // echo "<br> cap nhat thanh cong hay khong";
    // print_r($update->updateNguoiDung($MaNguoiDung, $TenTaiKhoan, $NgaySinh, $GioiTinh, $Sdt, $email, $DiaChi, $TaiKhoan, $DoiTuong));
    $redirect_url = "../ManagerController/NguoiDungController.php?page=User&numpage=1";
    header("Location: $redirect_url");

    exit();
  } else if ($_POST["action"] == "createUser") {
    $TenTaiKhoan = $_POST["HoTen"];
    $NgaySinh = $_POST["NgaySinh"];
    $DiaChi = $_POST["DiaChi"];
    $GioiTinh = $_POST["Gender"];
    $Sdt = $_POST["Sdt"];
    $email = $_POST["Email"];
    $DoiTuong = $_POST["DoiTuong"];
    $TaoNguoiDung = new NguoiDungModel();
    $TaoNguoiDung->createNguoiDung($TenTaiKhoan, $NgaySinh, $GioiTinh, $Sdt, $email, $DiaChi, $DoiTuong);
    // print_r($TaoNguoiDung->createNguoiDung($TenTaiKhoan,$NgaySinh,$GioiTinh,$Sdt,$email,$DiaChi,$DoiTuong));
    $redirect_url = "../ManagerController/NguoiDungController.php?page=User&numpage=1";
    header("Location: $redirect_url");
  }
}
