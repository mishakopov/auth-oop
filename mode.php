<?php
require_once "conf.php";

class MyDB
{
    private $connection = "";
    private $configs = [];

    public function __construct()
    {
        $this->configs = [
            'servername' => Config::$SERVERNAME,
            'username'   => Config::$USERNAME,
            'password'   => Config::$PASSWORD,
            'dbname'     => Config::$DBNAME
        ];
        $this->connectToDB();
    }


    function connectToDB(){
        $this->connection = mysqli_connect($this->configs['servername'], $this->configs['username'], $this->configs['password'] ,$this->configs['dbname']);
        if (!$this->connection){
            die("Connection failed " .  mysqli_connect_error());
        }
    }

    public function registerUser(array $userDetails){
        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `created_at`) VALUES 
      ('" . $userDetails['name'] . "' , '"
            . $userDetails['email'] . "', '"
            . password_hash($userDetails['password'], PASSWORD_BCRYPT) . "','"
            . date('Y-m-d H:i:s', time()) . "')";

        $result = mysqli_query( $this->connection, $sql);

        return $result;
    }

    public function userExist($email){
        $sql = " Select * FROM `users` WHERE email='$email' ";
        $result = mysqli_query($this->connection, $sql);
        $result = mysqli_fetch_assoc($result);
        return $result ?  true : false ;
    }

    public function getUser($email){
        $sql = "Select * from `users` WHERE email = '$email' ";
        $result = mysqli_query($this->connection, $sql);
        $result = mysqli_fetch_assoc($result);
        return $result;
    }

    public function updateUser($data){
        $sql = "UPDATE users SET name = '" . $data['name'] . "' , email = '" . $data['email'] . "'  WHERE email = '" . $_SESSION['user']['email'] . "'";
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }

    public function resetPassword($data){
        $sql = "UPDATE users SET password  = '" . password_hash($data['newpass'], PASSWORD_BCRYPT) . "' WHERE email = '" . $_SESSION["user"]["email"]. "'";
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }

    public function createPost($data){
        $sql = "INSERT INTO posts (`user_id`, `title`, `body`, `image`, `created_at`) VALUES(" . $data['user_id'] . " , '" . $data['title'] . "', '" . $data['body'] . "', '" . $data['image'] . "', '" . $data['created_at'] . "')";
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }
    public function getPosts(){
        $sql = "Select posts.*, users.name  from posts join users on posts.user_id = users.id";
        $result = mysqli_query($this->connection , $sql);
        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    public function getSinglePost($postid){
        $sql = "Select posts.*, users.name  from posts join users on posts.user_id = users.id WHERE posts.id = $postid";
        $result = mysqli_query($this->connection , $sql);
        $result = mysqli_fetch_assoc($result);
        return $result;
    }



}
