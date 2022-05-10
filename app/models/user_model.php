<?php

namespace model;

// データベースから取ってきたユーザー情報を格納するモデル
class UserModel extends AbstractModel
{
    public $id;
    public $name;
    public $password;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_user';
}
