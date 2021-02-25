<?php
require_once 'mode.php';
require_once 'PostController.php';

$obj = new PostController();

$posts = $obj->getSinglePost($_GET['post']);
?>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-lg-3">
            <img style="width: 200px; height: 200px;" src="uploads/<?= $posts['image']; ?>" alt="">
            <h3><?= $posts['title'] ?></h3>
            <p><?= $posts['body']?> </p>
            <p><?= date('M j, Y' ,strtotime($posts['created_at']))?> </p>
            <p><?= $posts['name'] ?></p>
        </div>
    </div>
