<?php

namespace db;

use db\DataSource;
use model\TopicModel;

class TopicQuery
{
    // ログインしているユーザーに紐付く記事を取得するメソッド
    public static function fetchByUserId($user)
    {
        // クエリを発行
        $db = new DataSource;

        // プリペアードステートメントを使うのでidはパラメータにしておく
        // deleted_atがnullのもののみ取得するようにし、論理的に無効なレコードは取得しないようにする
        // order byで新しい記事から順に表示
        $sql = 'SELECT t.*, c.name FROM topics t
                LEFT JOIN categories c
                ON t.category_id = c.id
                WHERE t.user_id = :id
                AND t.deleted_at is null
                order by t.id desc
                ';
        // 第2引数のパラメータに、引数で渡ってきた文字列を入れる
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        return $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);
    }


    // カテゴリに紐づく記事を取得する
    public static function fetchByCategoryId($category)
    {
        // 渡ってきたトピックオブジェクトのidが正しいか確認
        // if (!$category->isValidId()) {
        //     return false;
        // }

        $db = new DataSource;

        $sql = 'SELECT t.*, c.name FROM topics t
                LEFT JOIN categories c
                ON t.category_id = c.id
                WHERE c.id = :id
                AND t.deleted_at is null
                ORDER BY t.id DESC
                ';

        return $db->select($sql, [
            ':id' => $category->id
        ], DataSource::CLS, TopicModel::class);
    }


    // idから個別の記事を取ってくるメソッド
    public static function fetchById($topic)
    {
        $db = new DataSource;

        $sql = 'SELECT t.*, c.name FROM topics t
                LEFT JOIN categories c
                ON t.category_id = c.id
                WHERE t.id = :id
                and t.deleted_at IS NULL
                ';

        return $db->selectOne($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, TopicModel::class);
    }


    public static function update($topic)
    {
        $db = new DataSource;

        $sql = 'UPDATE topics
                SET title = :title,
                    body = :body,
                    position = :position,
                    complete_flg = :complete_flg,
                    category_id = :category_id
                WHERE id = :id
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':title' => $topic->title,
            ':body' => $topic->body,
            ':position' => $topic->position,
            ':complete_flg' => $topic->complete_flg,
            ':category_id' => $topic->category_id,
            ':id' => $topic->id
        ]);
    }


    public static function insert($topic, $user)
    {
        $db = new DataSource;

        $sql = 'INSERT INTO topics
                (title, body, position, category_id, user_id)
                values
                (:title, :body, :position, :category_id, :user_id)
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':title' => $topic->title,
            ':body' => $topic->body,
            ':position' => $topic->position,
            ':category_id' => $topic->category_id,
            ':user_id' => $user->id
        ]);
    }


    public static function delete($topic)
    {
        $db = new DataSource;

        $sql = 'UPDATE topics
                SET deleted_at = NOW()
                WHERE id = :id
                ';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':id' => $topic->id
        ]);
    }


    // ユーザーに紐付くトピックの数を返すメソッド
    public static function countByUserId($user)
    {
        $db = new DataSource;

        $sql = 'SELECT count(*) AS topic_num
                FROM topics
                WHERE user_id = :id
                AND deleted_at is null
                ';

        $result = $db->selectOne($sql, [
            ':id' => $user->id
        ]);

        return $result['topic_num'];
    }


    // カテゴリーに紐付くトピックの数を返すメソッド
    public static function countByCategoryId($category)
    {
        $db = new DataSource;

        $sql = 'SELECT count(*) AS topic_num
                FROM topics t
                LEFT JOIN categories c
                ON t.category_id = c.id
                WHERE c.id = :id
                AND t.deleted_at is null
                ';

        $result = $db->selectOne($sql, [
            ':id' => $category->id
        ]);

        return $result['topic_num'];
    }


    // ユーザーIDに紐付くトピックを部分的に取得するメソッド
    public static function fetchByUserIdPartially($user, $current_page)
    {
        // 配列の何番目から取得するか
        $start_no = ($current_page - 1) * MAX;

        $db = new DataSource;

        $sql = 'SELECT t.*, c.name FROM topics t
                LEFT JOIN categories c
                ON t.category_id = c.id
                WHERE t.user_id = :id
                AND t.deleted_at is null
                ORDER BY t.id DESC
                LIMIT :max
                OFFSET :start_no
                ';

        return $db->select($sql, [
            ':id' => $user->id,
            ':max' => MAX,
            ':start_no' => $start_no
        ], DataSource::CLS, TopicModel::class);
    }


    // カテゴリーIDに紐付くトピックを部分的に取得するメソッド
    public static function fetchByCategoryIdPartially($category, $current_page)
    {
        // 配列の何番目から取得するか
        $start_no = ($current_page - 1) * MAX;

        $db = new DataSource;

        $sql = 'SELECT t.*, c.name FROM topics t
                LEFT JOIN categories c
                ON t.category_id = c.id
                WHERE c.id = :id
                AND t.deleted_at is null
                ORDER BY t.id DESC
                LIMIT :max
                OFFSET :start_no
                ';

        return $db->select($sql, [
            ':id' => $category->id,
            ':max' => MAX,
            ':start_no' => $start_no
        ], DataSource::CLS, TopicModel::class);
    }


    // ページング付きのトピック表示に必要な値を返すメソッド
    public static function getTopicsByUserId($user)
    {
        // ユーザーに紐づくトピックの数を取得
        $topic_num = static::countByUserId($user);

        // 必要なページ数を取得（ceilで小数点を切り捨てる）
        $max_page = ceil($topic_num / MAX);

        // 現在のページを取得（設定されていない場合は１にする）
        $current_page = get_param('page', 1, false);

        // ページングの表示範囲を取得
        $range = getPagingRange($current_page, $max_page);

        // 現在のページ番号を元に、表示するトピックを部分的に取得
        $topics = static::fetchByUserIdPartially($user, $current_page);

        return [$topic_num, $max_page, $current_page, $range, $topics];
    }


    // ページング付きのトピック表示に必要な値を返すメソッド（カテゴリーごとのトピック表示の場合）
    public static function getTopicsByCategoryId($category)
    {
        // カテゴリーに紐づくトピックの数を取得
        $topic_num = static::countByCategoryId($category);

        // 必要なページ数を取得（ceilで小数点を切り捨てる）
        $max_page = ceil($topic_num / MAX);

        // 現在のページを取得（設定されていない場合は１にする）
        $current_page = get_param('page', 1, false);

        // ページングの表示範囲を取得
        $range = getPagingRange($current_page, $max_page);

        // 現在のページ番号を元に、表示するトピックを部分的に取得
        $topics = static::fetchByCategoryIdPartially($category, $current_page);

        return [$topic_num, $max_page, $current_page, $range, $topics];
    }
}
