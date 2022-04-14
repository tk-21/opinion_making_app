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
