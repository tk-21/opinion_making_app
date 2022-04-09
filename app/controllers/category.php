<?php

namespace controller\category;

use db\CategoryQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;
use model\CategoryModel;
use model\TopicModel;
use Throwable;

function get()
{

    Auth::requireLogin();

    $topic = new TopicModel;

    $topic->id = get_param('id', null, false);

    $fetchedTopic = TopicQuery::fetchById($topic);

    // トピックが取れてこなかったら４０４ページへリダイレクト
    if (!$fetchedTopic) {
        redirect('404');
        return;
    }

    // バリデーションに引っかかって登録に失敗した場合の処理
    // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
    // 必ずデータを取得した時点でデータを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
    $opinion = CategoryModel::getSessionAndFlush();

    if (empty($opinion)) {
        $opinion = new CategoryModel;
    }

    \view\opinion\index($opinion, $topic, true);
}


