<?php

namespace controller\home;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;

function get()
{

    // もしログインせずにこのページにアクセスしようとした場合（セッションにユーザー情報が入っていない場合）はログインページにリダイレクトさせる
    Auth::requireLogin();

    // セッションからユーザー情報を取得
    $user = UserModel::getSession();

    // ログインしているユーザーに紐付く記事を取得してくる
    $topics = TopicQuery::fetchByUserId($user);

    // ユーザーのセッションが何かおかしい場合は再度ログインしてもらう
    if (!$topics) {
        Msg::push(Msg::ERROR, 'ログインしてください。');
        redirect('login');
    }

    // 配列に値が入っていた場合
    if (count($topics) > 0) {
        // viewにあるメソッドを呼んでリストを表示する
        \view\home\index($topics);
    } else {
        // 記事がとれてこなかった場合はメッセージを表示
        echo '<div class="alert alert-primary">トピックを投稿してみよう。</div>';
    }


    // echo '<pre>', print_r($topics), '</pre>';
}
