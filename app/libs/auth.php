<?php
// 認証機能はこのファイルに書く

namespace lib;

use db\UserQuery;
use model\UserModel;
use Exception;

class Auth
{
    public static function login($name, $password)
    {
        try {
            // nameからユーザーを取得
            $user = UserQuery::fetchByName($name);

            // nameからユーザーが取れてこなかった場合
            if (empty($user) || $user->deleted_at) {
                Msg::push(Msg::ERROR, 'ユーザーがみつかりません。');
                return false;
            }

            // nameからユーザーが取れてきた場合、
            // パスワードの確認（DBに登録されているパスワードとの照合）を行う
            if (!password_verify($password, $user->password)) {
                Msg::push(Msg::ERROR, 'パスワードが一致しません。');
                return false;
            }

            // パスワードが一致した場合、ユーザー情報の入ったオブジェクトをセッションに格納
            UserModel::setSession($user);
            $is_success = true;
        } catch (Exception $e) {
            // 例外が発生した場合はfalseになるようにしておく
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ログイン処理でエラーが発生しました。少し時間をおいてから再度お試しください。');
        }

        return $is_success;
    }


    public static function regist($name, $password)
    {
        try {
            // 同じユーザーが存在するかどうかを確認
            $exist_user = UserQuery::fetchByName($name);

            if (!empty($exist_user)) {
                Msg::push(Msg::ERROR, 'すでにユーザーが存在します。');
                return false;
            }

            // モデルに格納
            $user = new UserModel;
            $user->name = $name;
            $user->password = $password;

            // 処理が成功したかどうかのフラグ。初期値はfalse。ログインが成功したときはtrueを入れる
            $is_success = false;

            // クエリを実行して登録が成功すれば$is_successにtrueが入る
            $is_success = UserQuery::insert($user);

            if ($is_success) {
                // 登録が成功すれば、そのユーザー情報をセッションに入れる（$_SESSION[_user] = $user）
                UserModel::setSession($user);
            }
        } catch (Exception $e) {
            // 例外が発生した場合はfalseになるようにしておく
            $is_success = false;
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'ユーザー登録でエラーが発生しました。少し時間をおいてから再度お試しください。');
        }

        return $is_success;
    }


    // ログインしているかどうかを判定するメソッド
    // セッションにユーザー情報が入っていればtrueを返す
    public static function isLogin()
    {
        try {
            $user = UserModel::getSession();
        } catch (Exception $e) {
            // ユーザー認証に関わるので、例外が発生した場合はユーザーをログアウトさせる
            UserModel::clearSession();
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'エラーが発生しました。再度ログインを行ってください。');
            // 例外が発生した時点でfalseを返す
            return false;
        }

        if (!isset($user)) {
            return false;
        }

        return true;
    }


    // ログインを促すメソッド
    public static function requireLogin()
    {
        // セッションにユーザー情報が入っていない場合、メッセージを出してログイン画面へリダイレクトさせる
        if (!static::isLogin()) {
            Msg::push(Msg::ERROR, 'ログインしてください。');
            redirect('login');
        }
    }


    // ログアウトするメソッド
    public static function logout()
    {
        try {
            // ユーザープロパティのセッション情報が削除される
            UserModel::clearSession();
        } catch (Exception $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            // 例外が発生した時点でfalseを返す
            return false;
        }

        // 例外が発生しなかったらtrueを返す
        return true;
    }
}
