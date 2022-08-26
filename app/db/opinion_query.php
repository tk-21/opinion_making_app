<?php

namespace db;

use db\DataSource;
use model\OpinionModel;

class OpinionQuery
{
    // controllerのdetail.phpで呼び出している
    public static function fetchByTopicId($topic)
    {
        $db = new DataSource;

        $sql = 'SELECT * FROM opinions
                WHERE topic_id = :id
                AND deleted_at IS NULL
                ';
        // 第2引数のパラメータは指定しないので、空の配列を渡す
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        $result = $db->selectOne($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, OpinionModel::class);

        // 結果が取れてくればresultを返す
        return $result;
    }


    // controller\topic\detailのpostメソッド内で呼び出している
    public static function insert($opinion)
    {
        $db = new DataSource;

        $sql = 'INSERT into opinions
                    (opinion, reason, topic_id)
                values
                    (:opinion, :reason, :topic_id)
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':opinion' => $opinion->opinion,
            ':reason' => $opinion->reason,
            ':topic_id' => $opinion->topic_id
        ]);
    }


    public static function update($opinion)
    {
        $db = new DataSource;
        // idをキーにして更新
        $sql = 'UPDATE opinions set
                    opinion = :opinion,
                    reason = :reason
                WHERE id = :id';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':opinion' => $opinion->opinion,
            ':reason' => $opinion->reason,
            ':id' => $opinion->id
        ]);
    }


    public static function delete($id)
    {
        $db = new DataSource;

        $sql = 'UPDATE objections
                set deleted_at = now()
                where id = :id;';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':id' => $id
        ]);
    }
}
