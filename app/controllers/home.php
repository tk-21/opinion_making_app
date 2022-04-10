<?php

namespace controller\home;

use db\CategoryQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;
use model\CategoryModel;
use Throwable;


function get()
{

    // もしログインせずにこのページにアクセスしようとした場合（セッションにユーザー情報が入っていない場合）はログインページにリダイレクトさせる
    Auth::requireLogin();

    // セッションからユーザー情報を取得
    $user = UserModel::getSession();

    // ユーザーのセッションが何かおかしい場合は再度ログインしてもらう
    if (!$user) {
        Msg::push(Msg::ERROR, 'ログインしてください。');
        redirect('login');
    }

    // ログインしているユーザーに紐付くトピックを取得してくる
    $topics = TopicQuery::fetchByUserId($user);

    $categories = CategoryQuery::fetchByUserId($user);

    // トピックがなかった場合
    if (!$topics) {
        // viewのindexメソッドを呼んでリストを表示する
        \view\home\index($topics, $categories);
        return;
    }


    // 記事の件数を取得
    $topics_num = count($topics);

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
    \view\home\index($topics, $categories, $topics_num, $max_page, $page, $range);
}


function post()
{

    Auth::requireLogin();

    $user = UserModel::getSession();

    $category = new CategoryModel;

    $category->name = get_param('name', null);
    $category->user_id = $user->id;


    try {
        $is_success = CategoryQuery::insert($category);
    } catch (Throwable $e) {
        Msg::push(Msg::ERROR, $e->getMessage());
        $is_success = false;
    }

    if (!$is_success) {
        Msg::push(Msg::ERROR, 'カテゴリの登録に失敗しました。');
        CategoryModel::setSession($category);
        redirect(GO_REFERER);
    }

    Msg::push(Msg::INFO, 'カテゴリを登録しました。');
    redirect(GO_HOME);
}
