<?php

namespace db;

use db\DataSource;
use model\TopicModel;

class TopicQuery
{
    // 引数でユーザー情報が渡ってくる
    // ログインしているユーザーに紐付く記事を取得するメソッド
    public static function fetchByUserId($user)
    {
        // クエリを発行
        $db = new DataSource;

        // プリペアードステートメントを使うのでidはパラメータにしておく
        // deleted_atがnullのもののみ取得するようにし、論理的に無効なレコードは取得しないようにする
        // order byで新しい記事から順に表示
        $sql = 'SELECT * FROM topics
                WHERE user_id = :id and deleted_at is null
                order by id desc
                ';
        // 第2引数のパラメータに、引数で渡ってきた文字列を入れる
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);

        // 結果が取れてくればresultを返す
        return $result;
    }


    // idから個別の記事を取ってくるメソッド
    public static function fetchById($topic)
    {
        if (!$topic->isValidId()) {
            return false;
        }

        $db = new DataSource;

        // 汎用性を持たせるためwhereの条件に t.published = 1 は入れない （公開非公開は関係なくトピックを取得する）
        // DBに問い合わせるクエリに詳細な条件を書いてしまうと、そのメソッドを使い回すことができない
        $sql = 'SELECT * FROM topics
                WHERE id = :id
                and deleted_at IS NULL
                ';
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // $resultにはオブジェクトの配列が格納される
        $result = $db->selectOne($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, TopicModel::class);

        // 結果が取れてくればresultを返す
        return $result;
    }


    public static function update($topic)
    {
        // 値のチェック
        // DBに接続する前に必ずチェックは終わらせておく
        // バリデーションがどれか一つでもfalseで返ってきたら、呼び出し元のedit.phpにfalseを返して登録失敗になる
        if (
            // ()の中が０の場合にはtrueになり、if文の中が実行される
            // trueまたはfalseを返すメソッドを*の演算子でつなげると、１または０に変換される。これらをすべて掛け合わせたときに結果が０であれば、どれかのチェックがfalseで返ってきたことになる
            !($topic->isValidId()
                * $topic->isValidTitle()
                * $topic->isValidBody()
                * $topic->isValidPosition()
                * $topic->isValidStatus())
        ) {
            return false;
        }

        $db = new DataSource;
        // idをキーにしてpublishedとtitleを更新
        $sql = 'UPDATE topics set title = :title,
                    body = :body,
                    position = :position,
                    complete_flg = :complete_flg
                WHERE id = :id
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':title' => $topic->title,
            ':body' => $topic->body,
            ':position' => $topic->position,
            ':complete_flg' => $topic->complete_flg,
            ':id' => $topic->id
        ]);
    }


    public static function insert($topic, $user)
    {
        // 値のチェック
        // DBに接続する前に必ずチェックは終わらせておく
        // バリデーションがどれか一つでもfalseで返ってきたら、呼び出し元のedit.phpにfalseを返して登録失敗になる
        if (
            // ()の中が０の場合にはtrueになり、if文の中が実行される
            // trueまたはfalseを返すメソッドを*の演算子でつなげると、１または０に変換される。これらをすべて掛け合わせたときに結果が０であれば、どれかのチェックがfalseで返ってきたことになる
            !($topic->isValidTitle()
                * $topic->isValidBody()
                * $topic->isValidPosition())
        ) {
            return false;
        }

        $db = new DataSource;

        $sql = 'INSERT into topics
                (title, body, position, user_id)
                values
                (:title, :body, :position, :user_id)
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':title' => $topic->title,
            ':body' => $topic->body,
            ':position' => $topic->position,
            ':user_id' => $user->id
        ]);
    }


    public static function delete($id)
    {
        $db = new DataSource;

        $sql = 'UPDATE topics
                SET deleted_at = NOW()
                WHERE id = :id
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':id' => $id
        ]);
    }
}
