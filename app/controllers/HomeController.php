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

        // ページネーション機能に必要な要素を取得
        [$topic_num, $max_page, $current_page, $range, $topics] = TopicQuery::getPagination($user);

        // ユーザーに紐付くカテゴリーを取得
        $categories = CategoryQuery::fetchByUserId($user);

        // viewのindexメソッドを呼んで一覧を表示する
        \view\home\index($topic_num, $max_page, $current_page, $range, $topics, $categories, true);
    }


    public function showTopicByCategory()
    {

        Auth::requireLogin();

        $category = new CategoryModel;

        $category->id = get_param('id', null, false);

        // ページネーション機能に必要な要素を取得
        [$topic_num, $max_page, $current_page, $range, $topics] = TopicQuery::getPaginationByCategory($category);

        $user = UserModel::getSession();
        $categories = CategoryQuery::fetchByUserId($user);

        \view\home\index($topic_num, $max_page, $current_page, $range, $topics, $categories, false);
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
