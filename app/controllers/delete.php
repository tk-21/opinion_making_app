<?php

namespace controller\delete;

use db\ObjectionQuery;
use db\TopicQuery;
use lib\Msg;

function get()
{
    $type = get_param('type', null, false);

    $id = get_param('id', null, false);

    if ($type === OBJECTION) {
        ObjectionQuery::delete($id) ? Msg::push(Msg::INFO, '削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

        redirect(GO_REFERER);
        return;
    }

    if ($type === TOPIC) {
        TopicQuery::delete($id) ? Msg::push(Msg::INFO, 'トピックを削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

        redirect(GO_HOME);
        return;
    }
}
