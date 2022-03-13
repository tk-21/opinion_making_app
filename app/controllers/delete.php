<?php

namespace controller\delete;

use db\ObjectionQuery;
use lib\Msg;

// getでリクエストが来た場合
function get()
{
    $id = get_param('id', null, false);

    if (ObjectionQuery::delete($id)) {
        // Msg::push(Msg::INFO, '削除しました。');
        redirect(GO_REFERER);
    } else {
        Msg::push(Msg::ERROR, '削除に失敗しました。');
    }
}
