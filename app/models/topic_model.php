<?php

namespace model;

class TopicModel extends AbstractModel
{
    public $id;
    public $title;
    public $body;
    public $position;
    public $complete_flg;
    public $category_id;
    public $user_id;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $name;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_topic';
}
