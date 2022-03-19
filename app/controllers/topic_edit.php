<?php

namespace controller\topic_edit;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get()
{
    // ログインしているかどうか確認
    Auth::requireLogin();

    // バリデーションに引っかかって登録に失敗した場合の処理
    // セッションに保存しておいた値を取ってきて変数に格納する。セッション上のデータは削除する
    // 必ずデータを取得した時点でデータを削除しておく必要がある。そうしないと他の記事を選択したときに出てきてしまう。
    $topic = TopicModel::getSessionAndFlush();

    // データが取れてくれば、その値を画面表示し、処理を終了
    if (!empty($topic)) {
        \view\topic_create\index($topic, false);
        return;
    }

    // データが取れてこなかった場合、TopicModelのインスタンスを作成して初期化
    $topic = new TopicModel;

    // GETリクエストから取得したidをモデルに格納
    $topic->id = get_param('id', null, false);

    // idからトピックの内容を取ってくる
    $fetchedTopic = TopicQuery::fetchById($topic);

    // トピックを渡してviewのindexを表示
    \view\topic_create\index($fetchedTopic, false);
}


function post()
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
    $topic->finish_flg = get_param('finish_flg', null);

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
