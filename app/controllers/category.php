<?php

namespace controller\category;

use db\TopicQuery;
use db\CategoryQuery;
use lib\Auth;
use model\UserModel;
use model\CategoryModel;

function get()
{

    Auth::requireLogin();

    $category = new CategoryModel;

    $category->id = get_param('id', null, false);

    $fetchedTopic = TopicQuery::fetchByCategoryId($category);

    // トピックが取れてこなかったら４０４ページへリダイレクト
    if (!$fetchedTopic) {
        redirect('404');
        return;
    }

    $user = UserModel::getSession();

    $categories = CategoryQuery::fetchByUserId($user);

    // バリデーションに引っかかって登録に失敗した場合の処理
    // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
    // 必ずデータを取得した時点でデータを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
    // $opinion = CategoryModel::getSessionAndFlush();

    // if (empty($opinion)) {
    //     $opinion = new CategoryModel;
    // }

    \view\home\index($fetchedTopic, $categories);
}


