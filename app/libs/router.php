<?php

namespace lib;

use controllers\TopicController\TopicController;
use Throwable;

// 渡ってきたパスによって呼び出すコントローラーを変えるメソッド
// index.php内でこのメソッドを呼び出す
function route($path, $method)
{
    // try catchは影響範囲の大きいところから書いていく
    try {
        // この記述を入れるとcatchの方に飛ぶ
        // throw new Error();

        // 何もなかったらhomeを入れる
        if ($path === '') {
            $path = 'home';
        }

        if ($path == 'topic/create') {
            $topic = new TopicController;
            $topic->create($method);
        }


        // 渡ってきたパスによってコントローラー内のどれかのファイル名を取得
        $targetFile = SOURCE_BASE . "controllers/{$path}.php";

        // コントローラー内に指定されたファイルが存在しなかったら404ページにとばす
        if (!file_exists($targetFile)) {
            require_once SOURCE_BASE . 'views/404.php';
            return;
        }

        // コントローラーの読み込み
        require_once $targetFile;

        // 渡ってきたパスの途中にあるスラッシュをバックスラッシュに置き換える
        // $path = str_replace('/', '\\', $path);

        // パスとメソッドによって関数を呼び分ける
        // 渡ってきたパスとメソッドに応じてnamespace内の関数（getかpostか）を指定
        // fnはfunctionの略
        // $fn = "\\controller\\{$path}\\{$method}";

        // それを実行する
        // 文字列で定義したものであっても、関数が見つかれば、末尾に()をつけることによって実行できる
        // $fn();
    } catch (Throwable $e) {
        // デバッグで何が起こったか確認できるようにする
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, '何かがおかしいようです。');
        // 404ページにとばす
        redirect('404');
    }
}
