<?php

namespace controller\detail;

use Throwable;
use db\ObjectionQuery;
use db\CounterObjectionQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\ObjectionModel;
use model\TopicModel;

function get()
{
    // まずログインを要求する
    Auth::requireLogin();

    $topic = new TopicModel;

    // $_GET['topic_id']から値を取ってくる
    // getから値を取るときは第３引数をfalseにしておく
    $topic->id = get_param('topic_id', null, false);

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに該当するトピックを１件取ってくる
    $fetchedTopic = TopicQuery::fetchById($topic);

    // トピックが取れてこなかった場合、またはpublishedの値がfalseの場合（０の場合）は４０４ページにリダイレクト
    if (empty($fetchedTopic)) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに紐付く反論を取ってくる
    $objections = ObjectionQuery::fetchByTopicId($topic);

    // topic_idが格納されたtopicオブジェクトを渡し、そのtopic_idに紐付く反論を取ってくる
    $counterObjections = CounterObjectionQuery::fetchByTopicId($topic);

    // トピックが取れてきた場合、viewのdetailのindexにtopicオブジェクトとcommentsオブジェクトを渡して実行
    \view\detail\index($fetchedTopic, $objections, $counterObjections);
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
        // コメント入力がされていれば、インサートのクエリを実行する
        if (!empty($objection->body)) {

            if ($formType === OBJECTION) {
                ObjectionQuery::insert($objection);
            } else {
                CounterObjectionQuery::insert($objection);
            }
        }
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
    }

    // 処理が終了したら画面を移動させる
    // redirect('detail?topic_id=' . $objection->topic_id);
    redirect(GO_REFERER);
}
