<?php

namespace controller\delete;

use model\TopicModel;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;

function get()
{
    Auth::requireLogin();

    $topic = new TopicModel;
    $topic->id = get_param('id', null, false);
    // idからトピックの内容を取ってくる
    $fetchedTopic = TopicQuery::fetchById($topic);
    // 削除確認画面を表示
    \view\topic\index($fetchedTopic, SHOW_DELETE);
}


function post()
{
    $id = get_param('id', null);
    TopicQuery::delete($id) ? Msg::push(Msg::INFO, 'トピックを削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

    redirect(GO_HOME);
}
