<?php

namespace db;

use db\DataSource;
use model\CategoryModel;

class CategoryQuery
{
    // controllerのdetail.phpで呼び出している
    public static function fetchByUserId($user)
    {
        // 渡ってきたトピックオブジェクトのidが正しいか確認
        if (!$user->isValidId()) {
            return false;
        }

        $db = new DataSource;

        $sql = 'SELECT * FROM categories
                WHERE user_id = :id
                AND deleted_at IS NULL
                ';
        // 第2引数のパラメータは指定しないので、空の配列を渡す
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, CategoryModel::class);

        // 結果が取れてくればresultを返す
        return $result;
    }


    // controller\topic\detailのpostメソッド内で呼び出している
    public static function insert($opinion)
    {
        // 値のチェック
        // DBに接続する前に必ずチェックは終わらせておく
        // バリデーションがどれか一つでもfalseで返ってきたら、呼び出し元にfalseを返して登録失敗になる
        if (
            // ()の中が０の場合にはtrueになり、if文の中が実行される
            // trueまたはfalseを返すメソッドを*の演算子でつなげると、１または０に変換される。これらをすべて掛け合わせたときに結果が０であれば、どれかのチェックがfalseで返ってきたことになる
            !($opinion->isValidTopicId()
                * $opinion->isValidOpinion()
                * $opinion->isValidReason()
            )
        ) {
            return false;
        }

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
        // 値のチェック
        // DBに接続する前に必ずチェックは終わらせておく
        // バリデーションがどれか一つでもfalseで返ってきたら、呼び出し元のedit.phpにfalseを返して登録失敗になる
        if (
            // ()の中が０の場合にはtrueになり、if文の中が実行される
            // trueまたはfalseを返すメソッドを*の演算子でつなげると、１または０に変換される。これらをすべて掛け合わせたときに結果が０であれば、どれかのチェックがfalseで返ってきたことになる
            !($opinion->isValidId()
                * $opinion->isValidOpinion()
                * $opinion->isValidReason()
            )
        ) {
            return false;
        }

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
