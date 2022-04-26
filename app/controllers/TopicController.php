<?php

namespace controllers;

use db\TopicQuery;
use db\CategoryQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use validation\TopicValidation;
use Exception;


class TopicController
{
    public function showCreateForm()
    {
        Auth::requireLogin();

        $user = UserModel::getSession();
        $categories = CategoryQuery::fetchByUserId($user);

        // バリデーションに引っかかって登録に失敗した場合の処理
        // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
        // 必ずデータを取得した時点で、データを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
        $topic = TopicModel::getSessionAndFlush();

        // データが取れてこなかった場合、TopicModelで初期化を行う
        if (empty($topic)) {
            $topic = new TopicModel;
        }

        \view\topic\index($topic, $categories, SHOW_CREATE);
    }


    public function create()
    {
        // ツールなどでもリクエストは投げれるので、必ずPOSTでもログインしているかどうか確認する
        Auth::requireLogin();

        $data = [
            'title' => get_param('title', null),
            'body' => get_param('body', null),
            'position' => get_param('position', null),
            'category_id' => get_param('category_id', null)
        ];

        try {
            // セッションに格納されているユーザー情報のオブジェクトを取ってくる
            $user = UserModel::getSession();

            // バリデーションに値をセット
            $validation = new TopicValidation;
            $validation->setData($data);

            if ($validation->check()) {
                $is_success = false;
            }
            
            $valid_data = $validation->getData();

            $topic = new TopicModel;

            // バリデーションを通った値をモデルに格納
            $topic->title = $valid_data['title'];
            $topic->body = $valid_data['body'];
            $topic->position = $valid_data['position'];
            $topic->category_id = $valid_data['category_id'];

            $is_success = TopicQuery::insert($topic, $user);
        } catch (Exception $e) {
            // エラー内容を出力する
            Msg::push(Msg::ERROR, $e->getMessage());
            $is_success = false;
        }
        // 失敗した場合
        if (!$is_success) {
            Msg::push(Msg::ERROR, 'トピックの登録に失敗しました。');
            // エラー時の値の復元のための処理
            // バリデーションに引っかかって登録に失敗した場合、入力した値を保持しておくため、セッションに保存する
            TopicModel::setSession($topic);

            // falseの場合は、メッセージを出して元の画面に戻す
            // このときに再びgetメソッドが呼ばれる
            redirect(GO_REFERER);
        }

        // 成功した場合
        Msg::push(Msg::INFO, 'トピックを登録しました。');
        redirect(GO_HOME);
    }


    public function showEditForm()
    {
        // ログインしているかどうか確認
        Auth::requireLogin();

        // バリデーションに引っかかって登録に失敗した場合の処理
        // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
        // 必ずデータを取得した時点でデータを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
        $topic = TopicModel::getSessionAndFlush();

        $user = UserModel::getSession();
        $categories = CategoryQuery::fetchByUserId($user);


        // データが取れてくれば、その値を画面表示し、処理を終了
        if (!empty($topic)) {
            \view\topic\index($topic, $categories, SHOW_EDIT);
            return;
        }

        // データが取れてこなかった場合、TopicModelのインスタンスを作成して初期化
        $topic = new TopicModel;

        // GETリクエストから取得したidをモデルに格納
        $topic->id = get_param('id', null, false);

        // idからトピックの内容を取ってくる
        $fetchedTopic = TopicQuery::fetchById($topic);

        // トピックが取れてこなかったら４０４ページへリダイレクト
        if (!$fetchedTopic) {
            redirect('404');
            return;
        }

        // トピックが取れてきたら、トピックを渡してviewのindexを表示
        \view\topic\index($fetchedTopic, $categories, SHOW_EDIT);
    }


    public function edit()
    {
        // ログインしているかどうか確認
        Auth::requireLogin();

        // TopicModelのインスタンスを作成
        $topic = new TopicModel;

        // POSTで渡ってきた値をモデルに格納
        $topic->id = get_param('id', null);
        $topic->title = get_param('title', null);
        $topic->body = get_param('body', null);
        $topic->position = get_param('position', null);
        $topic->complete_flg = get_param('complete_flg', null);
        $topic->category_id = get_param('category_id', null);

        // 更新処理
        try {
            // 更新が成功すればtrue,失敗すればfalseが返ってくる
            $is_success = TopicQuery::update($topic);
        } catch (Exception $e) {
            // エラー内容を出力する
            Msg::push(Msg::ERROR, $e->getMessage());
            $is_success = false;
        }

        // trueの場合は、メッセージを出してarchiveに移動
        if (!$is_success) {
            Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');

            // エラー時の値の復元のための処理
            // バリデーションに引っかかって登録に失敗した場合、入力した値を保持しておくため、セッションに保存する
            TopicModel::setSession($topic);

            // falseの場合は、メッセージを出して元の画面に戻す
            // このときに再びgetメソッドが呼ばれる
            redirect(GO_REFERER);
        }

        Msg::push(Msg::INFO, 'トピックを更新しました。');
        redirect(sprintf('detail?id=%d', $topic->id));
    }


    public function confirmDelete()
    {
        Auth::requireLogin();

        $topic = new TopicModel;
        $topic->id = get_param('id', null, false);
        // idからトピックの内容を取ってくる
        $fetchedTopic = TopicQuery::fetchById($topic);

        $user = UserModel::getSession();
        $categories = CategoryQuery::fetchByUserId($user);

        // 削除確認画面を表示
        \view\topic\index($fetchedTopic, $categories, SHOW_DELETE);
    }


    public function delete()
    {
        $id = get_param('id', null);
        TopicQuery::delete($id) ? Msg::push(Msg::INFO, 'トピックを削除しました。') : Msg::push(Msg::ERROR, '削除に失敗しました。');

        redirect(GO_HOME);
    }
}
