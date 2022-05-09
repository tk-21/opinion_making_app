<?php

namespace model;

class CategoryModel extends AbstractModel
{
    public $id;
    public $name;
    public $user_id;
    public $topic_id;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_category';
}
