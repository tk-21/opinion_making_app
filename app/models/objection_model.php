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


    public static function validateBody($body)
    {

        if (empty($body)) {
            Msg::push(Msg::ERROR, '反論を入力してください。');
            return false;
        }

        return true;
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
