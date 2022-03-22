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

    // 記事の件数を取得
    $topics_num = count($topics);

    // 記事があった場合
    if ($topics_num > 0) {

        // トータルページ数を取得（ceilで小数点を切り捨てる）
        $max_page = ceil($topics_num / MAX);

        // 現在のページ（設定されていない場合は１にする）
        $page = get_param('page', 1, false);

        // 配列の何番目から取得するか
        $start_no = ($page - 1) * MAX;

        // $start_noからMAXまでの配列を切り出す
        $topics = array_slice($topics, $start_no, MAX, true);

        // ページネーションを表示させる範囲
        if ($page === 1 || $page === $max_page) {
            $range = 4;
        } elseif ($page === 2 || $page === $max_page - 1) {
            $range = 3;
        } else {
            $range = 2;
        }

        // viewのindexメソッドを呼んでリストを表示する
        \view\home\index($topics, $topics_num, $page, $max_page, $range);
        return;
    }

    // 記事がとれてこなかった場合はメッセージを表示
    echo '<p class="alert">トピックを投稿してみよう。</p>';
}
