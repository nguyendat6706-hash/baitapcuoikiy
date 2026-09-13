<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . "/UTH-PHP";
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
require_once "$projectRoot/src/model/CartModel/CartModel.php";
require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";

class HomeController {
  public function display() {
    global $projectRoot;
    $modelProduct = new ProductModel();
    $loaiSanPhamModel = new LoaiSanPham();
    $dataLoaiSanPham = $loaiSanPhamModel->getAllTypeProduct(null, null)->data;
    $dataSanPham = $modelProduct->getAllProducts(null, null, null, null, null, null, null, null, null, null);
    $dataBranch = $modelProduct->getProductBrand();
    $dataOrigin = $modelProduct->getProductOrigin();
    // Gọi view
    require_once "$projectRoot/src/view/home/homepage.php";
  }

  public function handleRequestFilter() {
    // Function to get value or null
    function getValueOrNull($param) {
      return isset($_POST[$param]) && $_POST[$param] !== '' ? $_POST[$param] : null;
    }

    // Get parameter values
    $page = getValueOrNull('page');
    $search = getValueOrNull('search');
    $theTich = getValueOrNull('theTich');
    $minGia = getValueOrNull('minGia');
    $maxGia = getValueOrNull('maxGia');
    $minNongDoCon = getValueOrNull('minNongDoCon');
    $maxNongDoCon = getValueOrNull('maxNongDoCon');
    $maLoaiSanPham = getValueOrNull('maLoaiSanPham');
    $brand = getValueOrNull('brand');
    $origin = getValueOrNull('origin');

    // Lấy danh sách sản phẩm dựa trên các tham số lọc
    $modelProduct = new ProductModel();
    $dataSanPham = $modelProduct->getAllProducts($page, $search, $theTich, $minGia, $maxGia, $minNongDoCon, $maxNongDoCon, $brand, $origin, $maLoaiSanPham);

    // Xử lý dữ liệu sản phẩm
    $productHtml = "";
    if (!empty($dataSanPham->data)) {
      foreach ($dataSanPham->data as $product) {
        $productHtml .= '
    <div class="row">
        <a href="#">
            <img src="' . $product['AnhMinhHoa'] . '" alt="' . $product['TenSanPham'] . '" class="product-image" data-productId="' . $product['MaSanPham'] . '"/>
            <div class="product-card-content">
                <div class="price" style="width:100%;">
                    <h4 class="name-product">' . $product['TenSanPham'] . '</h4>
                    <p class="price-tea">' . number_format($product['Gia'], 0, ',', '.') . 'đ</p>
                </div>
                <div class="buy-btn-container">
                    <button type="submit" data-productId="' . $product['MaSanPham'] . '" class="add-to-cart-btn"> Thêm vào giỏ hàng</button>
                </div>
            </div>
        </a>
    </div>';
      }
    } else {
      $productHtml = "<p>Không có sản phẩm phù hợp.</p>";
    }

    // Xử lý dữ liệu phân trang
    $paginationHtml = "";
    if ($dataSanPham->totalPages > 1) {
      $paginationHtml = "<div class='pagination pagination-style-three m-t-20 m-b-40'>";
      for ($i = 1; $i <= $dataSanPham->totalPages; $i++) {
        $paginationHtml .= "<a href='#'>$i</a>";
      }
      $paginationHtml .= "</div>";
    }

    $responseData = array(
      'products' => $productHtml,
      'pagination' => $paginationHtml
    );

    header('Content-Type: application/json');
    echo json_encode($responseData);
  }

  public function handleRequestSwitchPage() {
    if (isset($_POST['maSanPham'])) {
      // Lấy mã sản phẩm từ dữ liệu gửi lên
      $maSanPham = $_POST['maSanPham'];

      // Đây là nơi bạn xử lý mã sản phẩm và trả về thông tin sản phẩm tương ứng
      // Ví dụ:
      $response = [
        'status' => 200,
        'productId' => $maSanPham
      ];

      // Chuyển định dạng dữ liệu thành JSON và trả về cho client
      echo json_encode($response);
    } else {
      // Nếu không có mã sản phẩm được gửi lên, trả về mã lỗi
      $response = [
        'status' => 400,
        'message' => 'Lỗi: Không có mã sản phẩm được gửi lên.'
      ];

      echo json_encode($response);
    }
  }
  public function show() {
    if (isset($_POST['action'])) {
      $action = $_POST['action'];
      switch ($action) {
        case "detailProduct":
          $this->handleRequestSwitchPage();
          break;
        case "filter":
          $this->handleRequestFilter();
          break;
      }
    } else {
      $this->display();
    }
  }
}

$homeController = new HomeController();
$homeController->show();
