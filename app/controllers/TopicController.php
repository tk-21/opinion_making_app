<?php

namespace controllers;

use db\TopicQuery;
use db\CategoryQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;


class TopicController
{
    public function index()
    {
        Auth::requireLogin();

        // セッションからユーザー情報を取得
        $user = UserModel::getSession();

        // ユーザーのセッションが何かおかしい場合は再度ログインしてもらう
        if (!$user) {
            Msg::push(Msg::ERROR, 'ログインしてください。');
            redirect('login');
        }

        // ログインしているユーザーに紐付くトピックを取得してくる
        $topics = TopicQuery::fetchByUserId($user);

        $categories = CategoryQuery::fetchByUserId($user);

        // トピックがなかった場合
        if (!$topics) {
            // viewのindexメソッドを呼んでリストを表示する
            \view\home\index($topics, $categories);
            return;
        }


        // 記事の件数を取得
        $topics_num = count($topics);

        // トータルページ数を取得（ceilで小数点を切り捨てる）
        $max_page = ceil($topics_num / MAX);

        // 現在のページ（設定されていない場合は１にする）
        $page = get_param('page', 1, false);

        // 配列の何番目から取得するか
        $start_no = ($page - 1) * MAX;

        // $start_noからMAXまでの配列を切り出す
        $topics = array_slice($topics, $start_no, MAX, true);

        // ページネーションを表示させる範囲
        if ($page === 1 || $page === $max_page) {
            $range = 4;
        } elseif ($page === 2 || $page === $max_page - 1) {
            $range = 3;
        } else {
            $range = 2;
        }

        // viewのindexメソッドを呼んでリストを表示する
        \view\home\index($topics, $categories, $topics_num, $max_page, $page, $range);
    }


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

        // インスタンスを作成
        $topic = new TopicModel;

        // POSTで渡ってきた（フォームで飛んできた）値をモデルに格納
        $topic->title = get_param('title', null);
        $topic->body = get_param('body', null);
        $topic->position = get_param('position', null);
        $topic->category_id = get_param('category_id', null);

        // 更新処理
        try {
            // セッションに格納されているユーザー情報のオブジェクトを取ってくる
            $user = UserModel::getSession();

            // ここでバリデーション

            // 更新が成功すればtrue,失敗すればfalseが返ってくる
            $is_success = TopicQuery::insert($topic, $user);
        } catch (Throwable $e) {
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
        } catch (Throwable $e) {
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
}
