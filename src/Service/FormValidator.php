<?php


namespace App\Service;

class FormValidator
{
    protected $errors;


    public function checkEmpty($field)
    {
        if (empty($field)) {
            $this->errors = '* Ce champs est requis';
        }
        return $this;
    }

    public function verifyInput($field)
    {
        $field = trim($field);
        $field = stripcslashes($field);
        $field = htmlspecialchars($field);

        return $field;
    }
}
