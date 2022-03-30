<?php

namespace controller\detail;

use Throwable;
use db\ObjectionQuery;
use db\CounterObjectionQuery;
use db\TopicQuery;
use db\OpinionQuery;
use lib\Auth;
use lib\Msg;
use model\ObjectionModel;
use model\TopicModel;

function get()
{
    // まずログインを要求する
    Auth::requireLogin();

    $topic = new TopicModel;

    // $_GET['id']から値を取ってくる
    // getで値を取るときは第３引数をfalseにしておく
    $topic->id = get_param('id', null, false);

    // idに該当するトピックを１件取ってくる
    $fetchedTopic = TopicQuery::fetchById($topic);

    // トピックが取れてこなかった場合、または削除されている場合は４０４ページにリダイレクト
    if (empty($fetchedTopic) || isset($fetchedTopic->deleted_at)) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに紐付く反論、意見を取ってくる
    $objections = ObjectionQuery::fetchByTopicId($topic);
    $counterObjections = CounterObjectionQuery::fetchByTopicId($topic);
    $opinion = OpinionQuery::fetchByTopicId($topic);

    // 取れてきたものをviewに渡して表示
    \view\detail\index($fetchedTopic, $objections, $counterObjections, $opinion);
}


function post()
{
    // 初期化
    $objection = new ObjectionModel;

    // postで飛んできた値を格納する
    $objection->body = get_param('body', null);
    $objection->topic_id = get_param('topic_id', null);

    $formType = get_param('form_type', null);

    try {
        // 反論が入力がされていれば、インサートのクエリを実行する
        if (!empty($objection->body)) {

            if ($formType === OBJECTION) {
                ObjectionQuery::insert($objection);
            }

            if ($formType === COUNTER_OBJECTION) {
                CounterObjectionQuery::insert($objection);
            }
        }
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
    }

    // 処理が終了したら画面を移動させる
    redirect(GO_REFERER);
}
