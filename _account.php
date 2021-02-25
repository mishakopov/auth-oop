<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])){
    header('Location:index.php');
    die;
}
require_once "mode.php";
connectToDB();
$request = $_POST;
$errors = [];
if(!$request['name']){
    $errors['name'] = "Name is required.";
}
if(!$request['email']){
    $errors['email'] = "Email is required";
}elseif(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Email is not valid";
}elseif($_SESSION['user']['email'] !== $request['email']){
    if (userExist($request['email'])){
        $errors['email'] = "Email was taken";
    }
}
if(!empty($errors)){
    $_SESSION['errors'] = $errors;
    $_SESSION['old_inputs'] = $request;
    header('Location:account.php');
    die;
}
$result = updateUser($request);

if ($result){
    $_SESSION['user'] = $request;
    $_SESSION['success'] = 'You have successfully updated';
}else{
    $_SESSION['errors']['error'] = "Something went wrong";
}
header('Location:account.php');
die;