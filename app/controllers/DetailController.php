<?php

namespace controllers;

use db\DataSource;
use db\TopicQuery;
use db\OpinionQuery;
use db\ObjectionQuery;
use db\CounterObjectionQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\ObjectionModel;
use Exception;
use validation\ObjectionValidation;

class DetailController
{
    // インスタンス生成時にログイン確認を実行
    public function __construct()
    {
        Auth::requireLogin();
    }



    // トピックの詳細画面を表示する
    public function index()
    {
        $topic = new TopicModel;

        // $_GET['id']から値を取ってくる
        // getで値を取るときは第３引数をfalseに
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


    // 「反論」または「反論への反論」を削除する
    public function delete()
    {
        // 削除する項目のタイプとidを取得
        $delete_type = get_param('delete_type', null);
        $delete_id = get_param('delete_id', null);

        if ($delete_type === 'objection') {
            $is_success = ObjectionQuery::delete($delete_id);
            echo json_encode($is_success);
            return;
        }

        if ($delete_type === 'counterObjection') {
            $is_success = CounterObjectionQuery::delete($delete_id);
            echo json_encode($is_success);
            return;
        }
    }


    // 「反論」または「反論への反論」を登録する
    public function create()
    {
        $objection = new ObjectionModel;

        // postで飛んできた値をオブジェクトに格納する
        $objection->body = get_param('body', null);
        $objection->topic_id = get_param('topic_id', null);

        try {
            $validation = new ObjectionValidation($objection);

            if (!$validation->validateBody()) {
                Msg::push(Msg::ERROR, '反論の登録に失敗しました。');
                redirect(GO_REFERER);
            }

            $valid_data = $validation->getValidData();

            $formType = get_param('form_type', null);

            // 「意見に対する反論」の場合の登録処理
            if ($formType === 'create_objection') {
                ObjectionQuery::insert($valid_data);
            }

            // 「反論への反論」の場合の登録処理
            if ($formType === 'create_counterObjection') {
                CounterObjectionQuery::insert($valid_data);
            }
        } catch (Exception $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
        }

        // 処理が終了したら画面を移動させる
        redirect(GO_REFERER);
    }
}
