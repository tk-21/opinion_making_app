<?php

namespace controllers;

use db\TopicQuery;
use db\CategoryQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use model\CategoryModel;
use validation\TopicValidation;
use Exception;

class HomeController
{
    public function index()
    {
        Auth::requireLogin();

        // セッションからユーザー情報を取得
        $user = UserModel::getSession();


        // ユーザーのセッションが何かおかしい場合は再度ログインしてもらう
        if (!$user) {
            Msg::push(Msg::ERROR, 'ログインしてください。');
            redirect('login');
        }

        $categories = CategoryQuery::fetchByUserId($user);

        // ログインしているユーザーに紐付くトピックを取得してくる
        // $topics = TopicQuery::fetchByUserId($user);

        // トピックがなかった場合
        // if (!$topics) {
        //     // viewのindexメソッドを呼んでリストを表示する
        //     \view\home\index($topics, $categories);
        //     return;
        // }

        [$topics, $topics_num, $max_page, $current_page, $range] = TopicQuery::fetchTopics($user);

        // viewのindexメソッドを呼んでリストを表示する
        \view\home\index($topics, $categories, $topics_num, $max_page, $current_page, $range);
    }


    public function showTopicByCategory()
    {

        Auth::requireLogin();

        $category = new CategoryModel;

        $category->id = get_param('id', null, false);

        $fetchedTopic = TopicQuery::fetchByCategoryId($category);

        $user = UserModel::getSession();
        $categories = CategoryQuery::fetchByUserId($user);


        // 記事の件数を取得
        $topics_num = count($fetchedTopic);

        // トータルページ数を取得（ceilで小数点を切り捨てる）
        $max_page = ceil($topics_num / MAX);

        // 現在のページ（設定されていない場合は１にする）
        $page = get_param('page', 1, false);

        // 配列の何番目から取得するか
        $start_no = ($page - 1) * MAX;

        // $start_noからMAXまでの配列を切り出す
        $topics = array_slice($fetchedTopic, $start_no, MAX, true);

        // ページネーションを表示させる範囲
        if ($page === 1 || $page === $max_page) {
            $range = 4;
        } elseif ($page === 2 || $page === $max_page - 1) {
            $range = 3;
        } else {
            $range = 2;
        }


        \view\home\index($topics, $categories, $topics_num, $max_page, $page, $range);
    }


    public function createCategory()
    {
        Auth::requireLogin();

        $user = UserModel::getSession();

        $category = new CategoryModel;

        $category->name = get_param('name', null);
        $category->user_id = $user->id;


        try {
            $is_success = CategoryQuery::insert($category);
        } catch (Exception $e) {
            Msg::push(Msg::ERROR, $e->getMessage());
            $is_success = false;
        }

        if (!$is_success) {
            Msg::push(Msg::ERROR, 'カテゴリの作成に失敗しました。');
            CategoryModel::setSession($category);
            redirect(GO_REFERER);
        }

        Msg::push(Msg::INFO, 'カテゴリを作成しました。');
        redirect(GO_HOME);
    }
}
