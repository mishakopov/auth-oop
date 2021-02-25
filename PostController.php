<?php

require_once 'mode.php';
require_once 'mustValidateInterface.php';
require_once 'base.php';
require_once 'validation.php';

class PostController extends BaseController implements MustValidateInterface
{
    use Validation;
    public $errors = [];

    public function __construct()
    {
        $this->request = $_POST;
        $this->model = new MyDB();
    }

    public function getPosts()
    {
        return $this->model->getPosts();
    }
    public function getSinglePost($postid)
    {
        return $this->model->getSinglePost($postid);
    }

    public function validateInputs()
    {

        $this->validateNotEmpty($this->request);
        $target_name = basename($_FILES['image']['name']);
        $this->image_type = pathinfo($target_name, PATHINFO_EXTENSION);
        if ($this->image_type !== 'jpg' && $this->image_type !== "png" && $this->image_type = "jpeg" && $this->image_type = "gif"){
            $this->errors['file_type'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

        }
    }

    public function createPost()
    {
        $this->validate(['redirect_path' => 'add_post.php']);
        $filename  = time() . '.'  . $this->image_type;
        $data = $this->request;
        if (move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $filename)){
            $data['image'] = $filename;
            $data['user_id'] = $this->model->getUser($_SESSION['user']['email'])['id'];
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->model->createPost($data);
            $_SESSION['success'] = "Post is created";
            $this->renderView('add_post.php');
        }

    }
}