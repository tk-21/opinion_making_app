<?php

namespace controller\delete;

use model\TopicModel;
use db\ObjectionQuery;
use db\CounterObjectionQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;

function get()
{
    Auth::requireLogin();

    // パラメータから、どれを削除するのかを取得
    $type = get_param('type', null, false);

    if ($type === 'topic') {
        $topic = new TopicModel;
        $topic->id = get_param('id', null, false);
        // idからトピックの内容を取ってくる
        $fetchedTopic = TopicQuery::fetchById($topic);
        // 削除確認画面を表示
        \view\topic\index($fetchedTopic, SHOW_DELETE);

        return;
    }

    $id = get_param('id', null, false);

    if ($type === 'objection') {
        // 削除に成功、失敗によって違うメッセージを出す
        ObjectionQuery::delete($id) ? Msg::push(Msg::INFO, '削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

        redirect(GO_REFERER);
        return;
    }

    if ($type === 'counter_objection') {
        // 削除に成功、失敗によって違うメッセージを出す
        CounterObjectionQuery::delete($id) ? Msg::push(Msg::INFO, '削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

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
