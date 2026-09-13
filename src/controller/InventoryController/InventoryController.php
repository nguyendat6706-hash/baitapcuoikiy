<?php
ERROR_REPORTING(E_ALL);
ini_set('DISPLAY_ERRORS', 1);
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/InventoryModel/InventoryModel.php";

class InventoryController {
  public function show() {
    global $projectRoot;
    $phieuNhapKhoModel = new InventoryModel();
    require_once "$projectRoot/src/view/admin/InventoryView/InventoryView.php";
  }
}

$inventoryController = new InventoryController();
$inventoryController->show();
