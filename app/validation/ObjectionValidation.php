<?php

namespace validation;

use lib\Msg;

class ObjectionValidation
{
    public $objection;

    public function setData($objection)
    {
        $this->objection = $objection;
    }

    public function getValidData()
    {
        return $this->objection;
    }


    public function validateId()
    {

        if (empty($this->objection->id) || !is_numeric($this->objection->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }


    public function validateBody()
    {

        if (empty($this->objection->body)) {
            Msg::push(Msg::ERROR, '反論を入力してください。');
            return false;
        }

        return true;
    }
}
