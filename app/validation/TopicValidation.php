<?php
namespace validation;

use lib\Msg;

class TopicValidation
{
    public function checkInput($val)
    {
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            return false;
        }


        return true;
    }
}
