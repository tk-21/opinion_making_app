<?php

namespace validation;

use lib\Msg;

class CategoryValidation
{
    private $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function getValidData()
    {
        return $this->category;
    }


    public function validateId()
    {

        if (empty($this->category->id) || !is_numeric($this->category->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }


    public function validateName()
    {

        if (empty($this->category->name)) {
            Msg::push(Msg::ERROR, 'カテゴリー名を入力してください。');
            return false;
        }

        return true;
    }
}
