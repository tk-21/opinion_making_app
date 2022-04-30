<?php

namespace controllers;

use lib\Auth;
use lib\Msg;
use model\UserModel;

class AuthController
{
    public function showLoginForm()
    {
        if (Auth::isLogin()) {
            redirect(GO_HOME);
        }

        \view\auth\index(true);
    }


    public function login()
    {
        $name = get_param('name', '');
        $password = get_param('password', '');

        // POSTで渡ってきたユーザーネームとパスワードでログインに成功した場合、
        if (Auth::login($name, $password)) {
            // 登録されたユーザーオブジェクトの情報を取ってくる
            $user = UserModel::getSession();
            // オブジェクトに格納されている情報を使って、セッションのINFOにメッセージを入れる
            Msg::push(Msg::INFO, "{$user->name}さん、ようこそ。");
            // パスが空だったらトップページに移動
            redirect(GO_HOME);
        } else {
            // Auth::loginによって何がエラーかというのはpushされるので、ここでエラーメッセージは出さなくてよい

            // refererは一つ前のリクエストのパスを表す
            // 認証が失敗したときは、一つ前のリクエスト（GETメソッドでのログインページへのパス）に戻る
            redirect(GO_REFERER);
        }
    }


    public function logout()
    {
        if (Auth::logout()) {
            Msg::push(Msg::INFO, 'ログアウトしました。');
            redirect('login');
        } else {
            Msg::push(Msg::ERROR, 'ログアウトに失敗しました。');
        }
    }


    public function showRegisterForm()
    {
        if (Auth::isLogin()) {
            redirect(GO_HOME);
        }

        \view\auth\index(false);
    }


    public function register()
    {
        $user = new UserModel;
        // $_POST['id']に値が設定されていればその値を$user->idに代入し、設定されていなければ、空文字を代入する
        $user->name = get_param('name', '');
        $user->password = get_param('password', '');

        // POSTで渡ってきた値をインスタンスのプロパティに代入した後、Userオブジェクトをregistに渡してあげる
        // 引数をある特定のモデルとすることで引数の記述を簡略化できる
        // 引数が多くなる場合もあるので、モデル自体を渡してやるとスッキリする
        if (Auth::regist($user)) {
            Msg::push(Msg::INFO, "{$user->name}さん、ようこそ。");
            redirect(GO_HOME);
        } else {
            redirect(GO_REFERER);
        }
    }
}
