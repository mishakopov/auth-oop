<?php
session_start();
require_once 'mode.php';
require_once 'base.php';
require_once 'mustValidateInterface.php';
require_once 'validation.php';

class PassResetController extends BaseController implements MustValidateInterface
{
    use Validation;

    public $errors = [];
    public function __construct()
    {
        $this->request = $_POST;
        $this->model = new MyDB();
    }

    public function validateInputs()
    {
        $this->validateNotEmpty($this->request);


        if($this->request['oldpass'] && !password_verify ($this->request['oldpass'], $this->model->getUser($_SESSION['user']['email'])['password'])){
            $this->errors['oldpass'] = "Old password doesn't equal";
        }

        if ($this->request['newpass'] && $this->request['newpass'] !== $this->request['confirmnewpass']){
            $this->errors['newpass'] = "Passwords doesn't match";
        }
    }

    public function resetPassword()
    {
        $this->validate(['redirect_path' => 'passreset.php']);

        $result = $this->model->resetPassword($this->request);

        if ($result){
            $_SESSION['user'] = $this->request;
            $_SESSION['success'] = 'Your password successfuly was reset';
        }else{
            $_SESSION['errors']['error'] = "Something went wrong";
        }

        $this->renderView('passreset.php');

    }
}

$passwordCtrl = new PassResetController();
$passwordCtrl->resetPassword();
