<?php

namespace model;

use lib\Msg;

class ObjectionModel extends AbstractModel
{
    public $id;
    public $body;
    public $topic_id;
    public $deleted_at;
    public $created_at;
    public $updated_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_objection';


    public static function validateBody($val)
    {
        $res = true;

        if (mb_strlen($val) > 100) {

            Msg::push(Msg::ERROR, '100文字以内で入力してください。');
            $res = false;
        }

        return $res;
    }

    public function isValidBody()
    {
        return static::validateBody($this->body);
    }


    public function isValidTopicId()
    {
        return TopicModel::validateId($this->topic_id);
    }
}
