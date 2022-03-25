<?php

namespace controller\register;

use lib\Auth;
use lib\Msg;
use model\UserModel;

// getでリクエストが来た場合
function get()
{
    if (Auth::isLogin()) {
        redirect(GO_HOME);
    }

    \view\auth\index(false);
}

// postでリクエストが来た場合
function post()
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
