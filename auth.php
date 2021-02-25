<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === "POST" && $_POST["action"] === "register" && !isset($_SESSION['user'])){
    require_once "_register.php";
}
if ($_SERVER['REQUEST_METHOD'] === "GET" && $_GET['logout'] === "true"){
    unset($_SESSION['user']);
    header('Location:login.php');
    die;
}
if ($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['action'] = "login" && !isset($_SESSION['user'])){
    require_once "_login.php";
}
