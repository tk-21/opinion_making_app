<?php

namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery
{
    public static function fetchByName($name)
    {
        $db = new DataSource;
        // プリペアードステートメントを使うのでidはパラメータにしておく
        $sql = 'SELECT * FROM users WHERE name = :name';
        // 第2引数にパラメータに、引数で渡ってきた文字列を入れる
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でUserModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\UserModel が返る）
        $result = $db->selectOne($sql, [
            ':name' => $name
        ], DataSource::CLS, UserModel::class);

        return $result;
    }


    public static function insert($user)
    {
        $db = new DataSource;
        $sql = 'INSERT into users
                (name, password)
                values(:name, :password)
                ';

        // パスワードはハッシュ化を行っておく
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':name' => $user->name,
            ':password' => $user->password
        ]);
    }
}
