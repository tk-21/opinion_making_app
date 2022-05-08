<?php

namespace validation;

use lib\Msg;

class UserValidation
{
    public function validateName($name)
    {
        if (empty($name)) {
            Msg::push(Msg::ERROR, 'ユーザーネームを入力してください。');
            return false;
        }

        // mb_strlenは半角でも全角でも文字数カウント分だけ返してくれるので、日本語をチェックするときはこの関数を使う
        if (mb_strlen($name) > 10) {
            Msg::push(Msg::ERROR, 'ユーザーネームは１０桁以下で入力してください。');
            return false;
        }

        return true;
    }


    public function validatePassword($password)
    {
        if (empty($password)) {
            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            return false;
        }

        // 半角のみを数えるときはstrlenでOK
        if (strlen($password) < 4) {
            Msg::push(Msg::ERROR, 'パスワードは４桁以上で入力してください。');
            return false;
        }

        // 小文字か大文字の半角英字もしくは数字にマッチするかどうかを判定
        if (!is_alnum($password)) {
            Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');
            return false;
        }

        return true;
    }
}