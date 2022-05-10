<?php

namespace validation;

use lib\Msg;

class CategoryValidation
{


    public static function validateId($category)
    {

        if (empty($category->id) || !is_numeric($category->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }



    public static function validateName($category)
    {

        if (empty($category->name)) {
            Msg::push(Msg::ERROR, 'カテゴリー名を入力してください。');
            return false;
        }

        return true;
    }
}
