<?php

namespace controller\opinion_edit;

use db\OpinionQuery;
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

    $opinion = OpinionModel::getSessionAndFlush();

    // セッションからデータが取れてきた場合、その値を画面表示して処理を終了
    if (!empty($opinion)) {
        \view\opinion_edit\index($opinion, $topic);
        return;
    }

    // データが取れてこなかった場合
    $fetchedOpinion = OpinionQuery::fetchByTopicId($topic);

    \view\opinion_edit\index($fetchedOpinion, $topic);
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
