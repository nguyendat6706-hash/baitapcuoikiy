<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/ProductModels/SanPhamModel.php";
session_start();
class ProductController {
  public function display() {
    global $projectRoot;
    $modelProduct = new ProductModel();
    $data = $modelProduct->getAllProductsNoStatus(null, null, null, null, null, null, null, null, null, null, null);
    require_once "$projectRoot/src/view/admin/product/informationProduct.php";
  }

  public function requestStatusProduct() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      echo json_encode(array("status" => 405, "message" => "Phương thức không được hỗ trợ."));
      return;
    }
    if (!isset($_POST['MaSanPham'])) {
      echo json_encode(array("status" => 400, "message" => "Thiếu thông tin MaSanPham."));
      return;
    }
    $MaSanPham = $_POST['MaSanPham'];

    $modelProduct = new ProductModel();
    $checkSoLuongConLai = $modelProduct->getProductById($MaSanPham)->data['SoLuongConLai'];
    if (!isset($checkSoLuongConLai)) {
      echo json_encode(array("status" => 400, "message" => "Không tìm thấy sản phẩm."));
      exit();
    } else {
      if ($checkSoLuongConLai == 0) {
        echo json_encode(array("status" => 400, "message" => "Số lượng còn lại bằng không nên không thể cập nhật."));
        exit();
      }
    }
    $result = $modelProduct->updateTrangThai($MaSanPham);

    if ($result) {
      echo json_encode(array("status" => 200, "message" => "Cập nhật trạng thái sản phẩm thành công."));
    } else {
      echo json_encode(array("status" => 500, "message" => "Đã xảy ra lỗi khi cập nhật trạng thái sản phẩm."));
    }
  }

  public function requestFilter() {
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
    $sort = getValueOrNull('sort');
    $brand = null;
    $origin = null;

    // Lấy danh sách sản phẩm dựa trên các tham số lọc
    $modelProduct = new ProductModel();
    $dataSanPham = $modelProduct->getAllProductsNoStatus($page, $search, $theTich, $minGia, $maxGia, $minNongDoCon, $maxNongDoCon, $brand, $origin, $maLoaiSanPham, $sort);

    $productHtml = "";
    if (!empty($dataSanPham->data)) {
      foreach ($dataSanPham->data as $product) {
        $statusClass = ($product['TrangThai'] == 1) ? 'btn-lock' : 'btn-open'; // Class "btn-lock" for status 1, class "btn-open" for status 0

        // Set button text depending on TrangThai value
        $activeButtonText = ($product['TrangThai'] == 1) ? 'Khóa' : 'Mở';
        $activeText = ($product['TrangThai'] == 1) ? 'Đang hoạt động' : 'Đang khóa';

        // Escape HTML attributes to prevent XSS vulnerabilities
        $maSanPham = htmlspecialchars($product['MaSanPham'], ENT_QUOTES, 'UTF-8');
        $tenSanPham = htmlspecialchars($product['TenSanPham'], ENT_QUOTES, 'UTF-8');
        $anhMinhHoa = htmlspecialchars($product['AnhMinhHoa'], ENT_QUOTES, 'UTF-8');
        $thuongHieu = htmlspecialchars($product['ThuongHieu'], ENT_QUOTES, 'UTF-8');
        $gia = htmlspecialchars($product['Gia'], ENT_QUOTES, 'UTF-8');
        $nongDoCon = htmlspecialchars($product['NongDoCon'], ENT_QUOTES, 'UTF-8');
        $theTich = htmlspecialchars($product['TheTich'], ENT_QUOTES, 'UTF-8');
        $xuatXu = htmlspecialchars($product['XuatXu'], ENT_QUOTES, 'UTF-8');
        $soLuongConLai = htmlspecialchars($product['SoLuongConLai'], ENT_QUOTES, 'UTF-8');

        // Build the table row
        $productHtml .= "
      <tr style=\"text-align: center\">
        <td>{$maSanPham}</td>
        <td><img src=\"{$anhMinhHoa}\" alt=\"{$tenSanPham}\"></td>
        <td>{$tenSanPham}</td>
        <td>{$thuongHieu}</td>
        <td>{$gia}</td>
        <td>{$nongDoCon}%</td>
        <td>{$theTich}ml</td>
        <td>{$xuatXu}</td>
        <td>{$soLuongConLai}</td>
        <td>{$activeText}</td>
        <td>
          <button class=\"editProduct\" data-maSanPham=\"{$maSanPham}\">sửa</button>
          <button class=\"setStatus {$statusClass}\" data-maSanPham=\"{$maSanPham}\">{$activeButtonText}</button>  
        </td>
      </tr>";
      }
    } else {
      $productHtml = "<p>Không có sản phẩm phù hợp.</p>";
    }

    $pagination = $dataSanPham->totalPages;

    $responseData = array(
      'products' => $productHtml,
      'pagination' => $pagination
    );

    header('Content-Type: application/json');
    echo json_encode($responseData);
  }

  public function show() {
    if (isset($_POST['action'])) {
      $action = $_POST['action'];
      switch ($action) {
        case "status":
          $this->requestStatusProduct();
          break;
        case "filter":
          $this->requestFilter();
          break;
      }
    } else {
      $this->display();
    }
  }
}

$prodcutController = new ProductController();
$prodcutController->show();
