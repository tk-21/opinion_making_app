<?php

namespace controller\opinion_edit;

use db\TopicQuery;
use db\OpinionQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use model\OpinionModel;
use Throwable;


function get()
{
    // ログインしているかどうか確認
    Auth::requireLogin();

    $topic = new TopicModel;

    $topic->id = get_param('id', null, false);

    // idからトピックの内容を取ってくる
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

    // データが取れてくれば、その値を画面表示し、処理を終了
    if (!empty($opinion)) {
        \view\opinion_create\index($opinion, $topic, false);
        return;
    }

    // idからトピックの内容を取ってくる
    $fetchedOpinion = OpinionQuery::fetchByTopicId($topic);

    // トピックを渡してviewのindexを表示
    \view\opinion_create\index($fetchedOpinion, $topic, false);
}


function post()
{

    Auth::requireLogin();

    $opinion = new OpinionModel;

    $opinion->id = get_param('id', null);
    $opinion->opinion = get_param('opinion', null);
    $opinion->reason = get_param('reason', null);
    $opinion->topic_id = get_param('id', null, false);

    try {
        $is_success = OpinionQuery::update($opinion);
    } catch (Throwable $e) {
        Msg::push(Msg::ERROR, $e->getMessage());
        $is_success = false;
    }

    if (!$is_success) {
        Msg::push(Msg::ERROR, '意見の更新に失敗しました。');
        OpinionModel::setSession($opinion);
        redirect(GO_REFERER);
    }

    Msg::push(Msg::INFO, '意見を更新しました。');
    redirect(sprintf('detail?id=%s', $opinion->topic_id));
}
