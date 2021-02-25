<?php
session_start();
if (!$_SESSION['user']){
    header('Location:../index.php');
    die;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Auth</title>
</head>
<body>
<div class="container">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Auth</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>

            </ul>
            <ul class="navbar-nav float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                        echo $_SESSION['user']['name'];
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="account.php">My account</a>
                        <a class="dropdown-item" href="auth.php?logout=true">Logout</a>
                        <a class="dropdown-item" href="passreset.php">Password Reset</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="center-container">
        <div class="card">
            <div class="card-header bg-info">
                Add Post
            </div>
            <div class="card-body">
                <?php
                if($_SESSION['errors'] ) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">";

                    foreach ($_SESSION['errors'] as $error) {
                        echo $error . "<br>";
                    }
                    echo "</div>";
                    unset($_SESSION['errors']);
                }
                if ($_SESSION['success']){
                    echo "<div class=\"alert alert-success\" role=\"alert\">";
                    echo $_SESSION['success'];
                    echo "</div>";
                    unset($_SESSION['success']);
                }
                ?>
                <form method="post" action="_add_post.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="<?php echo isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['name'] : '' ; ?>" >
                    </div>
                    <div class="form-group">
                        <label for="email">Body</label>
                        <textarea name="body" class="form-control" id="body" placeholder="Body" value="<?php echo isset($_SESSION['old_inputs']) ? $_SESSION['old_inputs']['email'] : ''; ?>" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Upload Image</label>
                        <input type="file" name="image" class="form-control" id="image" placeholder="Image"/>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
unset($_SESSION['old_inputs']);
?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
