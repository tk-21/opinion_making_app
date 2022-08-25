<?php

namespace controllers;

use db\TopicQuery;
use db\CategoryQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;
use model\CategoryModel;
use Exception;
use validation\CategoryValidation;

class CategoryController
{
    // インスタンス生成時にログイン確認を実行
    public function __construct()
    {
        Auth::requireLogin();
    }



    // カテゴリーの作成
    public function createCategory()
    {
        $user = UserModel::getSession();

        $category = new CategoryModel;

        $category->user_id = $user->id;
        $category->name = get_param('name', null);

        try {
            $validation = new CategoryValidation($category);

            if (!$validation->validateName()) {
                Msg::push(Msg::ERROR, 'カテゴリーの作成に失敗しました。');
                CategoryModel::setSession($category);
                redirect(GO_REFERER);
            }

            $valid_data = $validation->getValidData();

            CategoryQuery::insert($valid_data) ? Msg::push(Msg::INFO, 'カテゴリーを作成しました。') : Msg::push(Msg::ERROR, 'カテゴリーの作成に失敗しました。');

            redirect(GO_HOME);
        } catch (Exception $e) {
            Msg::push(Msg::ERROR, $e->getMessage());
        }
    }
}
