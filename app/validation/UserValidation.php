<?php

namespace validation;

use lib\Msg;

class UserValidation
{
    private $name;
    private $password;
    private $email;

    public function __construct($name, $password, $email = "")
    {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
    }

    public function getValidName()
    {
        return $this->name;
    }

    public function getValidPassword()
    {
        return $this->password;
    }

    public function getValidEmail()
    {
        return $this->email;
    }


    public function validateName()
    {
        if (empty($this->name)) {
            Msg::push(Msg::ERROR, 'ユーザーネームを入力してください。');
            return false;
        }

        // mb_strlenは半角でも全角でも文字数カウント分だけ返してくれるので、日本語をチェックするときはこの関数を使う
        if (mb_strlen($this->name) > 10) {
            Msg::push(Msg::ERROR, 'ユーザーネームは１０桁以下で入力してください。');
            return false;
        }

        return true;
    }


    public function validatePassword()
    {
        if (empty($this->password)) {
            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            return false;
        }

        // 半角のみを数えるときはstrlenでOK
        if (strlen($this->password) < 4) {
            Msg::push(Msg::ERROR, 'パスワードは４桁以上で入力してください。');
            return false;
        }

        // 小文字か大文字の半角英字もしくは数字にマッチするかどうかを判定
        if (!is_alnum($this->password)) {
            Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');
            return false;
        }

        return true;
    }


    public function validateEmail()
    {
        if (empty($this->email)) {
            Msg::push(Msg::ERROR, 'メールアドレスを入力してください。');
            return false;
        }

        if (!is_email($this->email)) {
            Msg::push(Msg::ERROR, 'メールアドレスは正しい形式で入力してください。');
            return false;
        }

        return true;
    }
}
