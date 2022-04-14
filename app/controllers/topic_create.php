<?php

namespace controller\topic_create;

use db\TopicQuery;
use db\CategoryQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;


function get()
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


function post()
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
