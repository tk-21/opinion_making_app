<?php

namespace controllers;

use db\TopicQuery;
use db\OpinionQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\OpinionModel;
use Exception;
use validation\OpinionValidation;

class OpinionController
{
    // インスタンス生成時にログイン確認を実行
    public function __construct()
    {
        Auth::requireLogin();
    }


    // 意見作成フォームを表示する
    public function showCreateForm()
    {
        $topic = new TopicModel;

        $topic->id = get_param('id', null, false);

        $fetchedTopic = TopicQuery::fetchById($topic);

        // トピックが取れてこなかったら４０４ページへリダイレクト
        if (!$fetchedTopic) {
            redirect('404');
            return;
        }

        // バリデーションに引っかかって登録に失敗した場合の処理
        // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
        // 必ずデータを取得した時点でデータを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
        $opinion = OpinionModel::getSessionAndFlush();

        if (empty($opinion)) {
            $opinion = new OpinionModel;
        }

        \view\opinion\index($opinion, $topic, true);
    }


    // 意見の登録処理
    public function create()
    {
        $opinion = new OpinionModel;

        $opinion->opinion = get_param('opinion', null);
        $opinion->reason = get_param('reason', null);
        $opinion->topic_id = get_param('id', null, false);


        try {
            $validation = new OpinionValidation;

            $validation->setData($opinion);

            if (!$validation->checkCreate()) {
                Msg::push(Msg::ERROR, '意見の登録に失敗しました。');

                OpinionModel::setSession($opinion);

                redirect(GO_REFERER);
            }

            $valid_data = $validation->getValidData();

            OpinionQuery::insert($valid_data) ? Msg::push(Msg::INFO, '意見を登録しました。') : Msg::push(Msg::INFO, '登録に失敗しました。');

            redirect(sprintf('detail?id=%s', $opinion->topic_id));
        } catch (Exception $e) {
            Msg::push(Msg::ERROR, $e->getMessage());
        }
    }


    // 意見の編集画面を表示する
    public function showEditForm()
    {
        $topic = new TopicModel;

        $topic->id = get_param('id', null, false);

        // idからトピックの内容を取ってくる
        $fetchedTopic = TopicQuery::fetchById($topic);

        // トピックが取れてこなかったら４０４ページへリダイレクト
        if (!$fetchedTopic) {
            redirect('404');
            return;
        }

        // バリデーションに引っかかって登録に失敗した場合の処理
        // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
        // 必ずデータを取得した時点でデータを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
        $opinion = OpinionModel::getSessionAndFlush();

        // データが取れてくれば、その値を画面表示し、処理を終了
        if (!empty($opinion)) {
            \view\opinion\index($opinion, $topic, false);
            return;
        }

        // idからトピックの内容を取ってくる
        $fetchedOpinion = OpinionQuery::fetchByTopicId($topic);

        // トピックを渡してviewのindexを表示
        \view\opinion\index($fetchedOpinion, $topic, false);
    }


    // 意見の更新処理
    public function edit()
    {
        $opinion = new OpinionModel;

        $opinion->id = get_param('id', null);
        $opinion->opinion = get_param('opinion', null);
        $opinion->reason = get_param('reason', null);
        $opinion->topic_id = get_param('id', null, false);

        try {
            $validation = new OpinionValidation;

            $validation->setData($opinion);

            if (!$validation->checkEdit()) {
                Msg::push(Msg::ERROR, '意見の更新に失敗しました。');
                OpinionModel::setSession($opinion);
                redirect(GO_REFERER);
            }

            $valid_data = $validation->getValidData();

            OpinionQuery::update($valid_data) ? Msg::push(Msg::INFO, '意見を更新しました。') : Msg::push(Msg::ERROR, '更新に失敗しました。');

            redirect(sprintf('detail?id=%s', $opinion->topic_id));
        } catch (Exception $e) {
            Msg::push(Msg::ERROR, $e->getMessage());
        }
    }
}
