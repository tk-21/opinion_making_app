<?php

namespace model;

class ObjectionModel extends AbstractModel
{
    public $id;
    public $body;
    public $topic_id;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_objection';
}
