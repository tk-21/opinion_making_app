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



    // カテゴリーの編集画面を表示する
    public function showEditForm()
    {
        // バリデーションに引っかかって登録に失敗した場合の処理
        // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
        // 必ずデータを取得した時点でデータを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
        $category = CategoryModel::getSessionAndFlush();

        // データが取れてくれば、その値を画面表示し、処理を終了
        if (!empty($category)) {
            \view\category_edit\index($category);
            return;
        }

        // データが取れてこなかった場合、TopicModelのインスタンスを作成して初期化
        $category = new CategoryModel;

        // GETリクエストから取得したidをモデルに格納
        $category->id = get_param('id', null, false);

        // バリデーションが失敗した場合は、画面遷移させない
        $validation = new CategoryValidation($category);

        if (!$validation->validateId()) {
            redirect(GO_REFERER);
        };

        $valid_data = $validation->getValidData();

        // idからトピックの内容を取ってくる
        $fetchedCategory = CategoryQuery::fetchById($valid_data->id);

        // トピックが取れてこなかったら４０４ページへリダイレクト
        if (!$fetchedCategory) {
            redirect('404');
            return;
        }

        // トピックが取れてきたら、トピックを渡してviewのindexを表示
        \view\category_edit\index($fetchedCategory);
    }
}
