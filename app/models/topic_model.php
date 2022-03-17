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


    public function isValidBody()
    {
        return static::validateBody($this->body);
    }

    public static function validateBody($val)
    {
        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, '本文を入力してください。');
            $res = false;
        } else {

            // mb_strlenは半角でも全角でも文字数カウント分だけ返してくれるので、日本語をチェックするときはこの関数を使う
            if (mb_strlen($val) > 100) {

                Msg::push(Msg::ERROR, '本文は100文字以内で入力してください。');
                $res = false;
            }
        }

        return $res;
    }


    public function isValidPosition()
    {
        return static::validatePosition($this->position);
    }

    public static function validatePosition($val)
    {
        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'ポジションを入力してください。');
            $res = false;
        } else {

            // mb_strlenは半角でも全角でも文字数カウント分だけ返してくれるので、日本語をチェックするときはこの関数を使う
            if (mb_strlen($val) > 100) {

                Msg::push(Msg::ERROR, 'ポジションは100文字以内で入力してください。');
                $res = false;
            }
        }

        return $res;
    }
}
