<?php

namespace model;

use lib\Msg;

class OpinionModel extends AbstractModel
{
    public $id;
    public $opinion;
    public $reason;
    public $topic_id;
    public $deleted_at;
    public $created_at;
    public $updated_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_opinion';


    public static function validateId($val)
    {
        $res = true;

        if (empty($val) || !is_numeric($val)) {

            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            $res = false;
        }

        return $res;
    }

    public function isValidId()
    {
        return static::validateId($this->id);
    }


    public function isValidOpinion()
    {
        return static::validateOpinion($this->opinion);
    }

    public static function validateOpinion($val)
    {
        $res = true;

        if (mb_strlen($val) > 100) {

            Msg::push(Msg::ERROR, '100文字以内で入力してください。');
            $res = false;
        }

        return $res;
    }


    public function isValidReason()
    {
        return static::validateReason($this->reason);
    }

    public static function validateReason($val)
    {
        $res = true;

        if (mb_strlen($val) > 100) {

            Msg::push(Msg::ERROR, '100文字以内で入力してください。');
            $res = false;
        }

        return $res;
    }


    public function isValidTopicId()
    {
        return TopicModel::validateId($this->topic_id);
    }
}
