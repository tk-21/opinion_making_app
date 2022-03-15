<?php

namespace controller\delete;

use db\ObjectionQuery;
use lib\Msg;

// postでリクエストが来た場合
function get()
{

    $id = get_param('id', null, false);

    ObjectionQuery::delete($id) ? Msg::push(Msg::INFO, '削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

    redirect(GO_REFERER);
}
