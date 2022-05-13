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
use validation\CategoryValidation;

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

        // ページング機能に必要な要素を取得
        [$topic_num, $max_page, $current_page, $range, $topics] = TopicQuery::getTopicsByUserId($user);

        // ユーザーに紐付くカテゴリーを取得
        $categories = CategoryQuery::fetchByUserId($user);

        // viewのindexメソッドを呼んで一覧を表示する
        \view\home\index($topic_num, $max_page, $current_page, $range, $topics, $categories, true, null);
    }


    public function showTopicsByCategory()
    {

        Auth::requireLogin();

        $id = get_param('id', null, false);

        $fetchedCategory = CategoryQuery::fetchById($id);

        // ページング機能に必要な要素を取得
        [$topic_num, $max_page, $current_page, $range, $topics] = TopicQuery::getTopicsByCategoryId($fetchedCategory);

        // ユーザーに紐付くカテゴリー一覧を取得
        $user = UserModel::getSession();
        $categories = CategoryQuery::fetchByUserId($user);

        \view\home\index($topic_num, $max_page, $current_page, $range, $topics, $categories, false, $fetchedCategory);
    }


    public function createCategory()
    {
        Auth::requireLogin();

        $user = UserModel::getSession();

        $category = new CategoryModel;

        $category->user_id = $user->id;
        $category->name = get_param('name', null);

        try {
            $validation = new CategoryValidation;

            if (!$validation->validateName($category)) {
                Msg::push(Msg::ERROR, 'カテゴリーの作成に失敗しました。');
                CategoryModel::setSession($category);
                redirect(GO_REFERER);
            }

            CategoryQuery::insert($category) ? Msg::push(Msg::INFO, 'カテゴリーを作成しました。') : Msg::push(Msg::ERROR, 'カテゴリーの作成に失敗しました。');

            redirect(GO_HOME);
        } catch (Exception $e) {
            Msg::push(Msg::ERROR, $e->getMessage());
        }
    }
}
