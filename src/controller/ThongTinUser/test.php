<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
require_once "$projectRoot/src/model/AccountModels/NguoiDungModel.php";
$nguoiDungModel = new NguoiDungModel();
$nguoiDung = $nguoiDungModel->getNguoiDungByMaTK($_SESSION['MaTaiKhoan']);
$data = $nguoiDung->data;
var_dump($data);
