<?php

namespace model;

use lib\Msg;

// データベースから取ってきたユーザー情報を格納するモデル
class UserModel extends AbstractModel
{
    // これらのプロパティに値を格納する
    public $id;
    public $name;
    public $password;
    public $deleted_at;
    public $created_at;
    public $updated_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_user';


    // ユーザーネームのバリデーション
    public static function validateName($val)
    {

        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'ユーザーネームを入力してください。');
            $res = false;
        } else {

            // mb_strlenは半角でも全角でも文字数カウント分だけ返してくれるので、日本語をチェックするときはこの関数を使う
            if (mb_strlen($val) > 10) {

                Msg::push(Msg::ERROR, 'ユーザーネームは１０桁以下で入力してください。');
                $res = false;
            }
        }

        return $res;
    }

    // インスタンスメソッドとしてはこのメソッドを使う
    public function isValidName()
    {
        return static::validateName($this->name);
    }


    // パスワードのバリデーション
    public static function validatePassword($val)
    {
        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            $res = false;
        } else {

            // 半角のみを数えるときはstrlenでOK
            if (strlen($val) < 4) {

                Msg::push(Msg::ERROR, 'パスワードは４桁以上で入力してください。');
                $res = false;
            }

            if (!is_alnum($val)) {

                Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');
                $res = false;
            }
        }

        return $res;
    }

    // インスタンスメソッドとしてはこのメソッドを使う
    public function isValidPassword()
    {
        return static::validatePassword($this->password);
    }
}
