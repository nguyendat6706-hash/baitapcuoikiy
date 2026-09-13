<?php
class LogOutController
{
  public function requestLogOut()
  {
    session_start();

    // Xóa tất cả các biến session
    $_SESSION = array();

    // Nếu muốn hủy vụng phiên, xóa cả session cookie.
    // Điều này sẽ hủy vụng phiên, và không chỉ đơn giản là xóa dữ liệu phiên
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    // Cuối cùng, hủy bỏ phiên
    session_destroy();

    // Chuyển hướng người dùng về trang chủ
    header("Location: /UTH-PHP/src/controller/HomeController/HomeController.php");
    exit;
  }
}
$logOutController = new LogOutController();
$logOutController->requestLogOut();
