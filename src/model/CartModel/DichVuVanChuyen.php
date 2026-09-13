<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/config/MysqlConfig.php";


class DichVuVanChuyen
{
  private $db;

  public function __construct()
  {
    $this->db = MysqlConfig::getConnection();
  }

  public function createDichVuVanChuyen($TenDichVu)
  {
    if (!isset($TenDichVu)) {
      return (object)[
        "status" => 400,
        "message" => "error value"
      ];
    }
    $query = "INSERT INTO `DichVuVanChuyen`(`TenDichVu`) VALUES (?)";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute([$TenDichVu]);
      return (object)[
        "status" => 200,
        "message" => "create success"
      ];
    } catch (\Throwable $th) {
      return (object)[
        "status" => 400,
        "message" => "create failed"
      ];
    }
  }

  public function getDichVuVanChuyen($id)
  {
    $query = "SELECT * FROM `DichVuVanChuyen` WHERE `id` = ?";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute([$id]);
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return (object)[
          "status" => 200,
          "data" => $result
        ];
      } else {
        return (object)[
          "status" => 404,
          "message" => "DichVuVanChuyen not found"
        ];
      }
    } catch (\Throwable $th) {
      return (object)[
        "status" => 400,
        "message" => "get failed"
      ];
    }
  }

  public function updateDichVuVanChuyen($id, $TenDichVu)
  {
    $query = "UPDATE `DichVuVanChuyen` SET `TenDichVu` = ? WHERE `id` = ?";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute([$TenDichVu, $id]);
      return (object)[
        "status" => 200,
        "message" => "update success"
      ];
    } catch (\Throwable $th) {
      return (object)[
        "status" => 400,
        "message" => "update failed"
      ];
    }
  }

  public function deleteDichVuVanChuyen($id)
  {
    $query = "DELETE FROM `DichVuVanChuyen` WHERE `id` = ?";
    try {
      $statement = $this->db->prepare($query);
      $statement->execute([$id]);
      return (object)[
        "status" => 200,
        "message" => "delete success"
      ];
    } catch (\Throwable $th) {
      return (object)[
        "status" => 400,
        "message" => "delete failed"
      ];
    }
  }
  public function __destruct()
  {
    if ($this->db) {
      $this->db = null;
    }
  }
}
