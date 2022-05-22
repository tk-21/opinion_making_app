<?php

namespace validation;

use lib\Msg;

class OpinionValidation
{
    private $opinion;

    public function __construct($opinion)
    {
        $this->opinion = $opinion;
    }

    public function getValidData()
    {
        return $this->opinion;
    }


    public function validateId()
    {

        if (empty($this->opinion->id) || !is_numeric($this->opinion->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }


    public function validateOpinion()
    {

        if (empty($this->opinion->opinion)) {
            Msg::push(Msg::ERROR, '意見を入力してください。');
            return false;
        }

        return true;
    }


    public function validateReason()
    {

        if (empty($this->opinion->reason)) {
            Msg::push(Msg::ERROR, '理由を入力してください。');
            return false;
        }

        return true;
    }


    // 意見作成のときに実行するメソッド
    public function checkCreate()
    {
        if (
            !($this->validateOpinion() *
                $this->validateReason())
        ) {
            return false;
        }

        return true;
    }


    // 意見編集のときに実行するメソッド
    public function checkEdit()
    {
        if (
            !($this->validateId() *
                $this->validateOpinion() *
                $this->validateReason()
            )
        ) {
            return false;
        }

        return true;
    }
}
