<?php

namespace db;

use db\DataSource;
use model\ObjectionModel;

class ObjectionQuery
{
    // controllerのdetail.phpで呼び出している
    public static function fetchByTopicId($topic)
    {
        // 渡ってきたトピックオブジェクトのidが正しいか確認
        // if (!$topic->isValidId()) {
        //     return false;
        // }

        $db = new DataSource;

        $sql = 'SELECT * FROM objections
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


    // idから反論を取ってくるメソッド
    public static function fetchById($objection)
    {
        $db = new DataSource;

        $sql = 'SELECT * FROM objections
                WHERE id = :id
                AND deleted_at IS NULL
                ';

        return $db->selectOne($sql, [
            ':id' => $objection->id
        ], DataSource::CLS, ObjectionModel::class);
    }


    public static function insert($objection)
    {
        $db = new DataSource;

        $sql = 'INSERT into objections
                (body, topic_id)
                values
                (:body, :topic_id)
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':body' => $objection->body,
            ':topic_id' => $objection->topic_id,
        ]);
    }


    public static function update($objection)
    {
        $db = new DataSource;
        // idをキーにして更新
        $sql = 'UPDATE objections set
                    body = :body
                WHERE id = :id';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':body' => $objection->body,
            ':id' => $objection->id
        ]);
    }


    public static function delete($id)
    {
        $db = new DataSource;

        $sql = 'UPDATE objections
                set deleted_at = now()
                where id = :id
                ';

        $result = $db->execute($sql, [
            ':id' => $id
        ]);

        return $result;
    }
}
