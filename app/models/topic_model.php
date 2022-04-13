<?php

namespace model;

use lib\Msg;

class TopicModel extends AbstractModel
{
    public $id;
    public $title;
    public $body;
    public $position;
    public $complete_flg;
    public $category_id;
    public $user_id;
    public $deleted_at;
    public $created_at;
    public $updated_at;
    public $name;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_topic';


    public static function validateId($id)
    {

        if (empty($id) || !is_numeric($id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }

    public function isValidId()
    {
        return static::validateId($this->id);
    }



    public static function validateTitle($title)
    {

        if (empty($title)) {
            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            return false;
        }

        return true;
    }

    public function isValidTitle()
    {
        return static::validateTitle($this->title);
    }



    public static function validateBody($body)
    {

        if (empty($body)) {

            Msg::push(Msg::ERROR, '本文を入力してください。');
            return false;
        }

        return true;
    }

    public function isValidBody()
    {
        return static::validateBody($this->body);
    }



    public static function validatePosition($position)
    {

        if (empty($position)) {
            Msg::push(Msg::ERROR, 'ポジションを入力してください。');
            return false;
        }

        return true;
    }

    public function isValidPosition()
    {
        return static::validatePosition($this->position);
    }



    public static function validateStatus($complete_flg)
    {

        if ($complete_flg > 1 || $complete_flg < 0) {
            Msg::push(Msg::ERROR, 'ステータスの値が不正です。');
            return false;
        }

        return true;
    }

    public function isValidStatus()
    {
        return static::validateStatus($this->complete_flg);
    }
}
