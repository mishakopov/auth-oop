<?php

trait Validation
{
    private $except = [];

    public function except(array $data)
    {
        $this->except = $data;

        return $this;
    }

    public function validateNotEmpty(array $data)
    {
        //remove key which don't need to validate
        foreach ($this->except as $item){
            unset($data[$item]);
        }

        foreach ($data as $key => $item){
            if(!$item){
                $this->errors[$key] = ucfirst($key) . " is required";
            }
        }

        return $this;
    }
}