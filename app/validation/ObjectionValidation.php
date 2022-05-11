<?php

namespace validation;

use lib\Msg;

class ObjectionValidation
{


    public static function validateId($objection)
    {

        if (empty($objection->id) || !is_numeric($objection->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }


    public static function validateBody($objection)
    {

        if (empty($objection->body)) {
            Msg::push(Msg::ERROR, '反論を入力してください。');
            return false;
        }

        return true;
    }
}
