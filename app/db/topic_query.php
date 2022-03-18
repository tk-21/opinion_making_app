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
        $sql = 'SELECT * FROM topics WHERE user_id = :id and deleted_at is null order by id desc;';
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


    // controllerのhome.phpで呼び出している
    public static function fetchPublishedTopics()
    {
        $db = new DataSource;

        // inner joinで内部結合している
        $sql = '
        SELECT t.*, u.nickname FROM topics t
        inner join users u
        on t.user_id = u.id
        WHERE t.del_flg != 1
        and u.del_flg != 1
        and t.published = 1
        order by t.id DESC
        ';
        // 第2引数のパラメータは指定しないので、空の配列を渡す
        // 第3引数でDataSource::CLSを指定することにより、クラスの形式でデータを取得
        // 第4引数でTopicModelまでのパスを取得して、そのクラスを使うように指定
        // ::classを使うことで、名前空間付きのクラスの完全修飾名を取得することができる（この場合は model\TopicModel が返る）
        // ここはselectメソッドなので複数行取れてくる
        // $resultにはオブジェクトの配列が格納される
        $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);

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
        $sql = '
            SELECT * FROM topics
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


    // ログインしているユーザー自身のトピックかどうかを判定するメソッド
    // auth.phpのhasPermissionメソッドで呼ばれている
    public static function isUserOwnTopic($topic_id, $user)
    {
        // 渡ってきたtopic_idをstaticメソッドで検査し、userオブジェクトをインスタンスメソッドで検査
        // どちらもtrueであれば後続の処理を実行する
        // どちらかがfalseであれば、return falseが実行される
        if (!(TopicModel::validateId($topic_id) && $user->isValidId())) {
            return false;
        }

        $db = new DataSource;

        // topicのidとuser_idの２つの条件で指定して、レコードが取れてくれば、そのユーザーが保持している記事と判断できるので編集可とする
        $sql = '
        select COUNT(1) as count FROM pollapp.topics t
        WHERE t.id = :topic_id
            AND t.user_id = :user_id
            AND t.del_flg != 1;
        ';
        // 連想配列の形式で結果が返る
        $result = $db->selectOne($sql, [
            ':topic_id' => $topic_id,
            ':user_id' => $user->id
        ]);

        // 取得した結果が空でないかつcountが０でなかったらtrueを返す
        return !empty($result) && $result['count'] != 0;
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
                * $topic->isValidPosition())
        ) {
            return false;
        }

        $db = new DataSource;
        // idをキーにしてpublishedとtitleを更新
        $sql = 'update topics set
                    title = :title,
                    body = :body,
                    position = :position,
                    finish_flg = :finish_flg
                where id = :id';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':title' => $topic->title,
            ':body' => $topic->body,
            ':position' => $topic->position,
            ':finish_flg' => $topic->finish_flg,
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
        $sql = 'insert into topics(title, body, position, user_id) values(:title, :body, :position, :user_id)';

        // 登録に成功すれば、trueが返される
        return $db->execute($sql, [
            ':title' => $topic->title,
            ':body' => $topic->body,
            ':position' => $topic->position,
            ':user_id' => $user->id
        ]);
    }
}
