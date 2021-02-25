<?php
session_start();
require_once '../PostController.php';

$obj = new PostController();
$obj->createPost();

