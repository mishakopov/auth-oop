<?php

require_once "mode.php";
require_once "base.php";
require_once 'mustValidateInterface.php';
require_once 'validation.php';

class RegisterController extends BaseController implements MustValidateInterface
{
    use Validation;

    protected $request;
    protected $errors;

    public function __construct()
    {
        $this->model = new MyDB();
        $this->request = $_POST;
        $this->errors = [];
    }

    public function validateInputs()
    {

        $this->except(['password_confirmation'])->validateNotEmpty($this->request);

        if(!filter_var($this->request['email'], FILTER_VALIDATE_EMAIL)){
            $this->errors['email_valid'] = "Email is not valid.";
        }elseif($this->model->userExist($this->request['email'])){
            $this->errors['email_taken'] = "Email was taken";
        }

        if ($this->request['password'] !== $this->request['password_confirmation']){
            $this->errors['password_confirm'] = "Passwords doesn't match.";
        }


    }

    public function register()
    {
        $this->validate(['redirect_path' => 'register.php']);
        $result = $this->model->registerUser($this->request);

        if ($result){
            $_SESSION['user'] = [
                'name' => $this->request['name'],
                'email' => $this->request['email']
            ];
            $this->renderView('index.php');
        }else{
            $_SESSION['errors']['error'] = "Something went wrong please try again";
            $_SESSION['old_inputs'] = $this->request;
            $this->renderView('register.php');
        }

    }

}

$register = new RegisterController();
$register->register();



