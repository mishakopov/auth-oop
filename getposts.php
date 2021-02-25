<?php

require_once 'PostController.php';

$postsController = new PostController();
$posts = $postsController->getPosts();
