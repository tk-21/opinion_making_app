<?php

namespace lib;

use model\AbstractModel;
use Throwable;

// リクエストをまたいでエラーが発生したかどうかというのを処理する場合はセッションを使って値を保持する必要がある
class Msg extends AbstractModel
{
    protected static $SESSION_NAME = '_msg';

    // 表示するメッセージの種類によってタイプを分けておく
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';


    // セッションを初期化するメソッド
    private static function init()
    {
        // セッションの初期値として配列が保存される
        static::setSession([
            static::ERROR => [],
            static::INFO => [],
            static::DEBUG => []
        ]);
    }


    // セッションにメッセージを詰めるためのメソッド
    public static function push($type, $msg)
    {
        // $_SESSION['_msg']から配列がとれてこなかったら、セッション上に配列を初期化する
        if (!is_array(static::getSession())) {
            static::init();
        }

        // 初期化された配列を代入
        $msgs = static::getSession();
        // 引数で渡ってきたタイプとメッセージを配列に格納
        $msgs[$type][] = $msg;
        // メッセージを格納した配列を$_SESSION['_msg']にセット
        static::setSession($msgs);
    }


    // メッセージを表示するためのメソッド
    public static function flush()
    {
        try {
            // もしセッションから何もとれてこなかったら空の配列を代入
            $msgs_with_type = static::getSessionAndFlush() ?? [];

            foreach ($msgs_with_type as $type => $msgs) {
                // $typeにデバッグが回ってきたとき、デバッグフラグがfalse（本番環境）だったら次のループにステップする
                if ($type === static::DEBUG && !DEBUG) {
                    continue;
                }

                // メッセージのタイプによって色を変える処理
                $color = $type === static::INFO ? 'msg-info' : 'msg-error';

                foreach ($msgs as $msg) {
                    echo sprintf('<p class="msg %s">%s</p>', $color, $msg);
                }
            }
        } catch (Throwable $e) {
            Msg::push(Msg::DEBUG, $e->getMessage());
            // メッセージを表示させて改修がしやすいようにしておく
            Msg::push(Msg::ERROR, 'Msg::Flushで例外が発生しました。');
        }
    }
}
