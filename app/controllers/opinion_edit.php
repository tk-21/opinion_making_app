<?php

namespace controller\opinion_edit;

use db\OpinionQuery;
use lib\Auth;
use lib\Msg;
use model\OpinionModel;
use model\UserModel;
use Throwable;

function get()
{

    Auth::requireLogin();

    $opinion = OpinionModel::getSessionAndFlush();

    \view\opinion_edit\index($opinion);
}


function post()
{

    Auth::requireLogin();

    $opinion = new OpinionModel;

    $opinion->opinion = get_param('opinion', null);
    $opinion->reason = get_param('reason', null);
    $opinion->topic_id = get_param('topic_id', null, false);


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
