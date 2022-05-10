<?php

namespace validation;

use lib\Msg;

class OpinionValidation
{


    public static function validateId($opinion)
    {

        if (empty($opinion->id) || !is_numeric($opinion->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }



    public static function validateOpinion($opinion)
    {

        if (empty($opinion->opinion)) {
            Msg::push(Msg::ERROR, '意見を入力してください。');
            return false;
        }

        return true;
    }


    public static function validateReason($opinion)
    {

        if (empty($opinion->reason)) {
            Msg::push(Msg::ERROR, '理由を入力してください。');
            return false;
        }

        return true;
    }


    // 意見作成のときに実行するメソッド
    public function checkCreate($opinion)
    {
        if (
            !($this->validateOpinion($opinion) *
                $this->validateReason($opinion))
        ) {
            return false;
        }

        return true;
    }


    // 意見編集のときに実行するメソッド
    public function checkEdit($opinion)
    {
        if (
            !($this->validateId($opinion) *
                $this->validateOpinion($opinion) *
                $this->validateReason($opinion)
            )
        ) {
            return false;
        }

        return true;
    }
}
