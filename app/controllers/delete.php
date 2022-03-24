<?php

namespace controller\delete;

use model\TopicModel;
use db\ObjectionQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;

function get()
{
    Auth::requireLogin();

    $topic = new TopicModel;

    // パラメータから、どれを削除するのかと、トピックのidを取得
    $type = get_param('type', null, false);
    $topic->id = get_param('id', null, false);

    if ($type === 'topic') {
        // idからトピックの内容を取ってくる
        $fetchedTopic = TopicQuery::fetchById($topic);
        // 削除確認画面を表示
        \view\topic\index($fetchedTopic, SHOW_DELETE);

        return;
    }

    if ($type === 'objection') {
        // 削除に成功、失敗によって違うメッセージを出す
        ObjectionQuery::delete($topic->id) ? Msg::push(Msg::INFO, '削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

        redirect(GO_REFERER);
        return;
    }
}


function post()
{
    $id = get_param('id', null);
    TopicQuery::delete($id) ? Msg::push(Msg::INFO, 'トピックを削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

    redirect(GO_HOME);
}
