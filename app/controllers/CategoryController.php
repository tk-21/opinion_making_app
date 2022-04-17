<?php

namespace controllers\CategoryController;

use db\TopicQuery;
use db\CategoryQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use model\CategoryModel;
use Throwable;


class CategoryController
{
    public function createCategory()
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
            Msg::push(Msg::ERROR, 'カテゴリの作成に失敗しました。');
            CategoryModel::setSession($category);
            redirect(GO_REFERER);
        }

        Msg::push(Msg::INFO, 'カテゴリを作成しました。');
        redirect(GO_HOME);
    }
}
