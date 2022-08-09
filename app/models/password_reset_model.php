<?php

namespace model;

class PasswordResetModel extends AbstractModel
{
    public $email;
    public $token;
    public $token_sent_at;

    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_password_reset';
}
