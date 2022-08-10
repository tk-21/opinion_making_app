<?php

namespace db;

use db\DataSource;
use model\UserModel;

class PasswordResetQuery
{
    public static function fetchByEmail($email)
    {
        $db = new DataSource;
        // プリペアードステートメントを使うのでidはパラメータにしておく
        $sql = 'SELECT * FROM password_resets WHERE email = :email';
        // 第2引数にパラメータに、引数で渡ってきた文字列を入れる
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でUserModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\UserModel が返る）
        $result = $db->selectOne($sql, [
            ':email' => $email
        ], DataSource::CLS, UserModel::class);

        return $result;
    }


    public static function insert($email, $passwordResetToken, $token_sent_at)
    {
        $db = new DataSource;
        $sql = 'INSERT into password_resets
                (email, token, token_sent_at)
                values(:email, :token, :token_sent_at)
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':email' => $email,
            ':token' => $passwordResetToken,
            ':token_sent_at' => $token_sent_at
        ]);
    }


    public static function update($email, $passwordResetToken, $token_sent_at)
    {
        $db = new DataSource;

        $sql = 'UPDATE password_resets set
                    token = :token,
                    token_sent_at = :token_sent_at
                WHERE email = :email';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':token' => $passwordResetToken,
            ':token_sent_at' => $token_sent_at,
            ':email' => $email
        ]);
    }


    public static function delete($passwordResetUser)
    {
        $db = new DataSource;

        $sql = 'DELETE FROM password_resets
                WHERE email = :email';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':email' => $passwordResetUser->email
        ]);
    }


    public static function fetchByToken($passwordResetToken)
    {
        $db = new DataSource;
        // プリペアードステートメントを使うのでidはパラメータにしておく
        $sql = 'SELECT * FROM password_resets WHERE token = :token';
        // 第2引数にパラメータに、引数で渡ってきた文字列を入れる
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でUserModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\UserModel が返る）
        $result = $db->selectOne($sql, [
            ':token' => $passwordResetToken
        ], DataSource::CLS, UserModel::class);

        return $result;
    }
}
