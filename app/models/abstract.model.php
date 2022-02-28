<?php

namespace model;

use Error;

// 先頭にabstractをつけることによって継承しないと使えないようにする（継承される前提のクラス）
abstract class AbstractModel
{
    protected static $SESSION_NAME = null;


    // セッションに情報を格納するメソッド
    public static function setSession($val)
    {
        if (empty(static::$SESSION_NAME)) {
            // 例外を発生させる
            throw new Error('$SESSION_NAMEを設定してください。');
        }
        // static::$SESSION_NAMEのところは、継承先で定義した$SESSION_NAMEが呼ばれる
        // static::をつけると、継承先まで探しに行く
        // 継承先のモデルによって値を変えれば、格納されるセッションのプロパティが変わってくる
        // static::$SESSION_NAMEは継承先のモデルで設定する
        $_SESSION[static::$SESSION_NAME] = $val;
    }


    // セッションに入っている値を返すメソッド
    public static function getSession()
    {
        // 何もとれてこなかったらnullを返す
        // noticeを発生させないために ?? nullを書いておく
        return $_SESSION[static::$SESSION_NAME] ?? null;
    }


    // セッションの値を空にするメソッド
    public static function clearSession()
    {
        static::setSession(null);
    }


    // セッションの値を取得して、その値をクリアするメソッド
    public static function getSessionAndFlush()
    {
        try {
            // セッションの値を呼び出し元に返却
            return static::getSession();
        } finally {
            // returnで値を返却する処理が終わった後に、値を削除する
            // finallyは必ず実行される
            static::clearSession();
        }
    }
}
