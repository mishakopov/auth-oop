<?php
require_once 'mode.php';
require_once 'Base.php';
require_once 'mustValidateInterface.php';
require_once 'validation.php';

class LoginController extends BaseController implements MustValidateInterface
{

    use Validation;

    public $request = [];
    private $userDetails  = NULL;
    public $errors = [];

    public function __construct()
    {
        $this->model = new MyDB();
        $this->request = $_POST;
    }


    public function validateInputs()
    {
        $this->validateNotEmpty($this->request);


        if (!$this->errors){

            if ($this->model->userExist($this->request['email'])){
                $this->userDetails = $this->model->getUser($this->request['email']);
                if (!password_verify($this->request['password'], $this->userDetails['password'])){
                    $this->errors['password'] = "Password doesn't match";
                }
            }else{
                $this->errors['email'] = "Email doesn't match";
            }
        }

    }


    public function login()
    {
        $this->validate(['redirect_path' => 'login.php']);

        $_SESSION['user'] = [
            'name' => $this->userDetails['name'],
            'email' => $this->userDetails['email'],
        ];

        $this->renderView('index.php');

    }

}


$login = new LoginController();
$login->login();







