<?php

namespace controllers;

use db\DataSource;
use db\TopicQuery;
use db\OpinionQuery;
use db\ObjectionQuery;
use db\CounterObjectionQuery;
use db\CategoryQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\ObjectionModel;
use model\OpinionModel;
use model\UserModel;
use validation\TopicValidation;
use Exception;


class DetailController
{
    public function index()
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


    public function delete($formType)
    {
        $delete_id = get_param('delete_id', null);

        // 「意見に対する反論」の削除処理
        if ($formType === 'delete_objection' && isset($delete_id)) {

            try {

                $db = new DataSource;
                $db->begin();
                $is_success = ObjectionQuery::delete($delete_id);
            } catch (Exception $e) {

                Msg::push(Msg::DEBUG, $e->getMessage());
                $is_success = false;
            } finally {

                if ($is_success) {
                    $db->commit();
                    Msg::push(Msg::INFO, '削除しました。');
                } else {
                    $db->rollback();
                    Msg::push(Msg::ERROR, '削除に失敗しました。');
                }

                redirect(GO_REFERER);
                return;
            }
        }

        // 「反論への反論」の削除処理
        if ($formType === 'delete_counterObjection' && isset($delete_id)) {

            try {

                $db = new DataSource;
                $db->begin();
                $is_success = CounterObjectionQuery::delete($delete_id);
            } catch (Exception $e) {

                Msg::push(Msg::DEBUG, $e->getMessage());
                $is_success = false;
            } finally {

                if ($is_success) {
                    $db->commit();
                    Msg::push(Msg::INFO, '削除しました。');
                } else {
                    $db->rollback();
                    Msg::push(Msg::ERROR, '削除に失敗しました。');
                }

                redirect(GO_REFERER);
                return;
            }
        }
    }


    public function create($formType)
    {
        $objection = new ObjectionModel;

        // postで飛んできた値を格納する
        $objection->body = get_param('body', null);
        $objection->topic_id = get_param('topic_id', null);

        try {
            // 反論が入力がされていれば、インサートのクエリを実行する
            if (!empty($objection->body)) {

                if ($formType === 'create_objection') {
                    ObjectionQuery::insert($objection);
                }

                if ($formType === 'create_counterObjection') {
                    CounterObjectionQuery::insert($objection);
                }
            }
        } catch (Exception $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
        }

        // 処理が終了したら画面を移動させる
        redirect(GO_REFERER);
    }
}
