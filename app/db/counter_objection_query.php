<?php

namespace db;

use db\DataSource;
use model\ObjectionModel;

class CounterObjectionQuery
{
    // controllerのdetail.phpで呼び出している
    public static function fetchByTopicId($topic)
    {
        // 渡ってきたトピックオブジェクトのidが正しいか確認
        // if (!$topic->isValidId()) {
        //     return false;
        // }

        $db = new DataSource;

        $sql = 'SELECT * FROM counter_objections
        WHERE topic_id = :id
        AND deleted_at IS NULL
        -- ORDER BY id DESC
        ';
        // 第2引数のパラメータは指定しないので、空の配列を渡す
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        $result = $db->select($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, ObjectionModel::class);

        // 結果が取れてくればresultを返す
        return $result;
    }


    public static function insert($counterObjection)
    {
        // 値のチェック
        // DBに接続する前に必ずチェックは終わらせておく
        // バリデーションがどれか一つでもfalseで返ってきたら、呼び出し元にfalseを返して登録失敗になる
        // if (
        // ()の中が０の場合にはtrueになり、if文の中が実行される
        // trueまたはfalseを返すメソッドを*の演算子でつなげると、１または０に変換される。これらをすべて掛け合わせたときに結果が０であれば、どれかのチェックがfalseで返ってきたことになる
        //     !($counterObjection->isValidTopicId()
        //         * $counterObjection->isValidBody()
        //     )
        // ) {
        //     return false;
        // }

        $db = new DataSource;

        $sql = 'INSERT into counter_objections
            (body, topic_id)
        values
            (:body, :topic_id)
        ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':body' => $counterObjection->body,
            ':topic_id' => $counterObjection->topic_id,
        ]);
    }


    public static function delete($id)
    {
        $db = new DataSource;

        $sql = 'UPDATE counter_objections
                set deleted_at = now()
                where id = :id
                ';

        $result = $db->execute($sql, [
            ':id' => $id
        ]);

        return $result;
    }
}
