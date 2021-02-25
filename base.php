<?php


abstract class BaseController
{
    protected $errors = [];
    protected $request = [];

    public abstract function validateInputs();

    public function renderView($path)
    {
        header('Location:' . $path);
        die;
    }

    public function validate(array $params)
    {
        $_SESSION['errors'] = [];
        $_SESSION['old_inputs'] = [];

        $this->validateInputs();

        if(!empty($this->errors)){
            $_SESSION['errors'] = $this->errors;
            $_SESSION['old_inputs'] = $this->request;
            $this->renderView($params['redirect_path']);
        }
    }
}