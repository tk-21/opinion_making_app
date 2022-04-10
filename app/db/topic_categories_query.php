<?php

namespace db;

use db\DataSource;
use model\TopicCategoriesModel;

class TopicCategoriesQuery
{

    public static function insert($category, $last_id)
    {

        $db = new DataSource;

        $sql = 'INSERT INTO topic_categories
                    (topic_id, category_id)
                values
                    (:topic_id, :category_id)
                ';

        // 登録に成功すれば、trueが返される
        foreach ($category->id as $id) {
            $result = $db->execute($sql, [
                ':topic_id' => $last_id[0],
                ':category_id' => $id
            ]);
        }

        return $result;
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
