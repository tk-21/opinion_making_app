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





    // public function isValidTopicId()
    // {
    //     return TopicModel::validateId($this->topic_id);
    // }
}
