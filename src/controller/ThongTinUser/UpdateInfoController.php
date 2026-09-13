<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require $projectRoot . '/src/model/AccountModels/NguoiDungModel.php';
session_start();
class UpdateInfoController {
  public function display() {
    global $projectRoot;
    require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";
    $nguoiDungModel = new NguoiDungModel();
    if (!isset($_SESSION['MaTaiKhoan'])) {
      header('Location: /UTH-PHP/src/controller/AccountController/AccountController.php');
    }
    $nguoiDung = $nguoiDungModel->getNguoiDungByMaTKClient($_SESSION['MaTaiKhoan']);
    $data = $nguoiDung->data;
    require_once  "$projectRoot/src/view/thongtinuser/updateinfo.php";
  }


  public function requestUpdateInformationUser() {
    if ($_SESSION['MaTaiKhoan']) {
      // Assuming you have a User model or some other way to handle database operations
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the data from the POST request
        $maTaiKhoan = $_POST['info-maTaiKhoan'];
        $hoTen = $_POST['name'];
        $ngaySinh = $_POST['info-date'];
        $gioiTinh = $_POST['gender'];
        $soDienThoai = $_POST['phone'];
        $email = $_POST['email'];
        $diaChi = $_POST['info-address'];
       

        $nguoiDungModel = new NguoiDungModel();
        $nguoiDung = $nguoiDungModel->updateNguoiDungForUser($maTaiKhoan,
        $hoTen,
        $ngaySinh,
        $gioiTinh,
        $soDienThoai,
        $email,
        $diaChi);
        // Check if the update operation was successful
        if ($nguoiDung->status === 200) {
          // Return a success message along with status code 200
          echo json_encode(array('status' => 200, 'message' => 'User information updated successfully','data' => $nguoiDung));
        } else {
          // Return an error message along with status code 500
          echo json_encode(array('status' => 500, 'message' => 'Failed to update user information'));
        }
        exit; // Don't forget to exit to prevent further execution
      }
    }
  }

  public function show() {
    if (isset($_POST['action']) && $_POST['action'] == 'updateInformationUser') {
      $this->requestUpdateInformationUser();
    } else {
      $this->display();
    }
  }
}

$updateInfoController = new UpdateInfoController();
$updateInfoController->show();
