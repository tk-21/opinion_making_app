<?php

namespace db;

use PDO;

class PDOSingleton
{
    // staticにすることによって、$singletonを取れば必ず同じフィールドのものが取れてくる
    private static $singleton;

    // privateなので外部から呼び出すことはできない
    private function __construct($dsn, $username, $password)
    {
        // データベースへのコネクションを取ってくる
        $this->conn = new PDO($dsn, $username, $password);
        //デフォルトのFETCH_MODEをFETCH_ASSOCに設定
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // 例外が発生したときに、PDOExceptionの例外を投げてくれるようにする
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // DBのプリペアードステートメントの機能を使うようにし、PDOの機能は使わないようにする設定↓
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    // このメソッド経由でインスタンスを取ってくる
    // このメソッドを実行することによって、$singletonのフィールドにデータベースへのコネクションが保持される
    // ２回目以降にアクセスされたときにはif文の中は実行されないので、必ず同じDBへのコネクションが取れてくる
    public static function getInstance($dsn, $username, $password)
    {
        // $singletonがnullであればインスタンス化を行って$singletonに格納する
        if (!isset(self::$singleton)) {
            $instance = new PDOSingleton($dsn, $username, $password);
            self::$singleton = $instance->conn;
        }
        return self::$singleton;
    }
}


class DataSource
{

    private $conn;
    private $sqlResult;

    // クラス内でなんらかのキーを使う場合は、静的プロパティとして定数を用意する
    public const CLS = 'cls';
    public const COLUMN = 'column';

    // DB接続
    public function __construct($dsn = DSN, $username = USER, $password = PASSWORD)
    {
        $this->conn = PDOSingleton::getInstance($dsn, $username, $password);
    }


    // SQLを実行し、ステートメントを返すメソッド
    private function executeSql($sql, $params)
    {
        // $sqlで渡ってきたsqlを渡してprepareを実行
        $stmt = $this->conn->prepare($sql);
        // $paramsで渡ってきた配列を渡して実行し、結果を$sqlResultに代入（成功すればtrueが代入される）
        $this->sqlResult = $stmt->execute($params);
        // ステートメントを返す
        return $stmt;
    }


    // 更新系はこのメソッドを使う
    // SQLを実行し、その結果をtrueかfalseで返すメソッド
    public function execute($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
        // PDOのexecuteと戻り値を同じにするため、$this->sqlResultを返す
        return  $this->sqlResult;
    }


    // データを複数行取ってくるメソッド
    // オブジェクト形式か連想配列形式かを第３引数で指定する。どちらかの形式で結果が帰ってくる
    public function select($sql = "", $params = [], $type = '', $cls = '')
    {
        $stmt = $this->executeSql($sql, $params);
        // typeがclsのときはフェッチモードをFETCH_CLASSに、columnのときはフェッチモードをFETCH_COLUMNに、それ以外の場合はFETCH_ASSOCにする
        if ($type === static::CLS) {
            // fetchAllの引数でFETCH_CLASSを使うと、第２引数で指定したクラスのプロパティにカラムの値を代入できる。一致するプロパティが存在しない場合は、そのプロパティが作成される。
            return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
        }

        if ($type === static::COLUMN) {
            // FETCH_COLUMNは指定した1つのカラムだけを1次元配列として取得する。
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // 上でデフォルトモードを連想配列に設定しているので改めてPDO::FETCH_ASSOC記述しなくてもよい
        return $stmt->fetchAll();
    }


    // 取得した配列の１行目だけを返すメソッド
    public function selectOne($sql = "", $params = [], $type = '', $cls = '')
    {
        $result = $this->select($sql, $params, $type, $cls);
        // countで空の配列ではないことを確認する
        // 1行だけ取ってきたいので、$resultの0番目を返す
        return count($result) > 0 ? $result[0] : false;
    }


    public function begin()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }
}
