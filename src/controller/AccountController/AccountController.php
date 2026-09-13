<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/AccountModels/TaiKhoanModel.php";
require_once "$projectRoot/src/model/AccountModels/PhanQuyenModel.php";
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";

class AccountController {
  public function display() {
    global $projectRoot;
    require_once "$projectRoot/src/view/include/header.php";
    require_once "$projectRoot/src/view/account/account.php";
    require_once "$projectRoot/src/view/include/footer.php";
  }

  public function requestSignIn() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      echo json_encode(array("status" => 405, "message" => "Phương thức không được hỗ trợ."));
      return;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $taikhoanModel = new TaiKhoanModel();
    $userData = $taikhoanModel->getUserByUsername($username);

    if ($userData->status === 200 && isset($userData->data)) {
      $validPassword = $userData->data['MatKhau'];
      $validPassword = str_replace(' ', '', $validPassword);

      if ($password === $validPassword) {

        // if (){
        session_start();
        $_SESSION['MaTaiKhoan'] = $userData->data['MaTaiKhoan'];
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['role'] = $userData->data['MaQuyen'];

        $phanQuyenModel = new PhanQuyenModel();
        $phanQuyenData = $phanQuyenModel->getChucNangByMaQuyen($userData->data['MaQuyen']);
        $_SESSION['chucNang'] = array();
        foreach ($phanQuyenData->data as $value) {
          $_SESSION['chucNang'][] = $value['MaChucNang'];
        }
        // } else{
        //   echo json_encode(array("status" => 400, "message" => "Tên người dùng hoặc mật khẩu không chính xác."));

        // }


        echo json_encode(array("status" => 200, "message" => "Đăng nhập thành công.", "userData" => $userData->data));
      } else {
        echo json_encode(array("status" => 401, "message" => "Tên người dùng hoặc mật khẩu không chính xác.", "user_status" => $userData->data));
      }
    } else {
      echo json_encode(array("status" => 400, "message" => "Tên người dùng hoặc mật khẩu không chính xác."));
    }
  }

  public function requestSignUp() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      echo json_encode(array("status" => 405, "message" => "Phương thức không được hỗ trợ."));
      return;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $confirmPassword = $_POST["confirmPassword"];

    if (!preg_match('/^[a-zA-Z0-9]{8,}$/', $username)) {
      echo json_encode(array("status" => 400, "message" => "Tên đăng nhập phải có ít nhất 8 ký tự và không được chứa dấu cách."));
      exit;
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
      echo json_encode(array("status" => 400, "message" => "Mật khẩu phải có 1 chữ thường, 1 chữ hoa, 1 số, 1 ký tự đặc biệt, ít nhất 8 ký tự."));
      exit;
    }

    if ($password !== $confirmPassword) {
      echo json_encode(array("status" => 400, "message" => "Passwords do not match."));
      exit;
    }

    $taiKhoanModel = new TaiKhoanModel();
    $userByUsername = $taiKhoanModel->getUserByUsername($username);
    if ($userByUsername->status === 200) {
      // Trả về lỗi nếu username đã tồn tại
      echo json_encode(array("status" => 400, "message" => "Username already exists."));
      exit;
    }

    $nguoiDungModel = new NguoiDungModel();
    $userByEmail = $nguoiDungModel->getUserByEmail($email);
    if ($userByEmail->status === 200) {
      echo json_encode(array("status" => 400, "message" => "Email already exists."));
      exit;
    }

    $result = $taiKhoanModel->createTaiKhoan($username, $password, 2, null, null, null, null, $email, null);

    if ($result->status === 200) {
      echo json_encode(array("status" => 200, "message" => "Sign up successful."));
      exit;
    } else {
      echo json_encode(array("status" => 500, "message" => "Sign up error.", "result" => $result));
      exit;
    }
  }

  public function show() {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
      if (isset($_POST['action']) && $_POST['action'] == 'signin') {
        $this->requestSignIn();
        exit(); // Kết thúc quá trình xử lý sau khi đã gửi phản hồi JSON
      } elseif (isset($_POST['action']) && $_POST['action'] == 'register') {
        $this->requestSignUp();
        exit();
      }
    } else {
      // Nếu không phải yêu cầu Ajax hoặc không phải là yêu cầu đăng nhập, hiển thị trang đăng nhập
      $this->display();
    }
  }
}

$AccountController = new AccountController();
$AccountController->show();
