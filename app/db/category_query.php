<?php

namespace db;

use db\DataSource;
use model\CategoryModel;

class CategoryQuery
{
    public static function fetchByUserId($user)
    {

        $db = new DataSource;

        $sql = 'SELECT * FROM categories
                WHERE user_id = :id
                AND deleted_at IS NULL
                ORDER BY id DESC
                ';
        // 第2引数のパラメータは指定しないので、空の配列を渡す
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, CategoryModel::class);

        // 結果が取れてくればresultを返す
        return $result;
    }


    public static function insert($category)
    {

        $db = new DataSource;

        $sql = 'INSERT INTO categories
                    (name, user_id)
                values
                    (:name, :user_id)
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':name' => $category->name,
            ':user_id' => $category->user_id
        ]);
    }


    public static function update($topic, $last_id)
    {
        $db = new DataSource;

        $sql = 'UPDATE categories set
                    topic_id = :topic_id
                WHERE id = :id';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':topic_id' => $last_id[0],
            ':id' => $topic->category_id
        ]);
    }


    public static function delete($id)
    {
        $db = new DataSource;

        $sql = 'UPDATE categories
                set deleted_at = now()
                where id = :id;';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':id' => $id
        ]);
    }
}
