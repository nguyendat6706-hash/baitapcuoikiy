 <?php

    $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
    require_once "$projectRoot/src/model/ProductTypeModel/LoaiSanPhamModel.php";
    // Initialize the LoaiSanPham object
    // Check if the request is an AJAX request
    // Initialize the LoaiSanPham object
    $loaiSanPham = new LoaiSanPham();


    if (isset($_GET['action'])){
        if ($_GET['action'] == "noPaging"){
            $result = $loaiSanPham->getAllTypeProductNoPaging();
        }
    }else{
        // Check if 'search' parameter exists
        if (isset($_GET['search'])) {
            // Call the getAllTypeProduct method to retrieve all product data with search parameter
            $result = $loaiSanPham->getAllTypeProduct($_GET['page'], $_GET['search']);
        } else {
            // Call the getAllTypeProduct method to retrieve all product data without search parameter
            $result = $loaiSanPham->getAllTypeProduct(1, $_GET['page']);
        }
    }

  

  

    // Output the result as JSON
    header('Content-Type: application/json');
    echo json_encode($result);
