<?php

namespace controller\opinion_create;

use db\OpinionQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\OpinionModel;
use model\TopicModel;
use model\UserModel;
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
    $opinion = OpinionModel::getSessionAndFlush();

    if (empty($opinion)) {
        $opinion = new OpinionModel;
    }

    \view\opinion\index($opinion, $topic, true);
}


function post()
{

    Auth::requireLogin();

    $opinion = new OpinionModel;

    $opinion->opinion = get_param('opinion', null);
    $opinion->reason = get_param('reason', null);
    $opinion->topic_id = get_param('id', null, false);


    try {
        $is_success = OpinionQuery::insert($opinion);
    } catch (Throwable $e) {
        Msg::push(Msg::ERROR, $e->getMessage());
        $is_success = false;
    }

    if (!$is_success) {
        Msg::push(Msg::ERROR, '意見の登録に失敗しました。');
        OpinionModel::setSession($opinion);
        redirect(GO_REFERER);
    }

    Msg::push(Msg::INFO, '意見を登録しました。');
    redirect(GO_HOME);
}
