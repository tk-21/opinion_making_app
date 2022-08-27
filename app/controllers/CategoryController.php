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
        $fetchedCategory = CategoryQuery::fetchById($valid_data);

        // トピックが取れてこなかったら４０４ページへリダイレクト
        if (!$fetchedCategory) {
            redirect('404');
            return;
        }

        // トピックが取れてきたら、トピックを渡してviewのindexを表示
        \view\category_edit\index($fetchedCategory);
    }



    // 更新
    public function edit()
    {
        $category = new CategoryModel;

        $category->id = get_param('id', null);
        $category->name = get_param('name', null);

        // 更新処理
        try {
            $validation = new CategoryValidation($category);

            // バリデーションに引っかかった場合
            if (!($validation->validateId() * $validation->validateName())) {
                Msg::push(Msg::ERROR, 'カテゴリーの更新に失敗しました。');
                // エラー時の値の復元のための処理
                // バリデーションに引っかかって登録に失敗した場合、入力した値を保持しておくため、セッションに保存する
                CategoryModel::setSession($category);

                // 元の画面に戻す
                redirect(GO_REFERER);
            }

            $valid_data = $validation->getValidData();

            // バリデーションに問題なかった場合、オブジェクトを渡してクエリを実行
            CategoryQuery::update($valid_data) ? Msg::push(Msg::INFO, 'カテゴリーを更新しました。') : Msg::push(Msg::ERROR, '更新に失敗しました。');

            redirect(sprintf('category?id=%d', $category->id));
        } catch (Exception $e) {
            // エラー内容を出力する
            Msg::push(Msg::ERROR, $e->getMessage());
        }
    }



    // 削除確認画面を表示する
    public function confirmDelete()
    {
        $category = new CategoryModel;
        $category->id = get_param('id', null, false);

        $validation = new CategoryValidation($category);

        if (!$validation->validateId()) {
            redirect(GO_REFERER);
        };

        $valid_data = $validation->getValidData();

        // idからトピックの内容を取ってくる
        $fetchedCategory = CategoryQuery::fetchById($valid_data);

        // 削除確認画面を表示
        \view\category_delete\index($fetchedCategory);
    }



    // トピックを削除する
    public function delete()
    {
        $category = new CategoryModel;
        $category->id = get_param('category_id', null);

        $validation = new CategoryValidation($category);

        if (!$validation->validateId()) {
            redirect(GO_REFERER);
        };

        $valid_data = $validation->getValidData();

        CategoryQuery::delete($valid_data) ? Msg::push(Msg::INFO, 'カテゴリーを削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

        redirect(GO_HOME);
    }
}
