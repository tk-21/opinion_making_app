<?php

namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;

// getでリクエストが来た場合
function get()
{
    if (Auth::isLogin()) {
        redirect(GO_HOME);
    }

    \view\auth\index(true);
}


// postでリクエストが来た場合
function post()
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
