<?php

namespace model;

use lib\Msg;

class TopicModel extends AbstractModel
{
    public $id;
    public $title;
    public $body;
    public $position;
    public $finish_flg;
    public $user_id;
    public $deleted_at;
    public $created_at;
    public $updated_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_topic';


    // インスタンスメソッドとしてはこのメソッドを使う
    public function isValidId()
    {
        return static::validateId($this->id);
    }

    public static function validateId($val)
    {
        $res = true;

        if (empty($val) || !is_numeric($val)) {

            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            $res = false;
        }

        return $res;
    }


    public function isValidTitle()
    {
        return static::validateTitle($this->title);
    }

    public static function validateTitle($val)
    {
        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            $res = false;
        } else {

            // mb_strlenは半角でも全角でも文字数カウント分だけ返してくれるので、日本語をチェックするときはこの関数を使う
            if (mb_strlen($val) > 30) {

                Msg::push(Msg::ERROR, 'タイトルは30文字以内で入力してください。');
                $res = false;
            }
        }

        return $res;
    }


    public function isValidPublished()
    {
        return static::validatePublished($this->published);
    }

    public static function validatePublished($val)
    {
        $res = true;

        if (!isset($val)) {

            Msg::push(Msg::ERROR, '公開するか選択してください。');
            $res = false;
        } else {
            // 0、または1以外の時
            if (!($val == 0 || $val == 1)) {

                Msg::push(Msg::ERROR, '公開ステータスが不正です。');
                $res = false;
            }
        }

        return $res;
    }
}
