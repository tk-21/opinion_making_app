<?php
// 共通で使う処理はこのファイルに書いていく


// 初期化処理を関数として定義する
// $_POSTや$_GETなどのスーパーグローバル変数はアクセスできるところを限定してやる。いたるところでアクセスできるようにしてしまうと修正が大変だから
function get_param($key, $default_val, $is_post = true)
{
    // $is_postのデフォルト値はtrueなので、省略されたときは$_POSTが代入される
    $array = $is_post ? $_POST : $_GET;
    // 値が飛んでこなかった場合には$default_valを設定する
    // null合体演算子
    // nullでないときは第一オペランドを返し、nullのときは第二オペランドを返す
    // 値が設定されているか確認して、設定されていなければ何らかの値を代入したいときに使う
    return $array[$key] ?? $default_val;
}


// 渡ってきた値をホスト名以下につなげてURLを返す関数
function get_url($path)
{
    // 両端にスラッシュが含まれていればトリミングする
    return BASE_PATH . trim($path, '/');
}


// get_urlで取得したURLを画面表示する関数
function the_url($path)
{
    echo get_url($path);
}


// 渡ってきた値が含まれるURLに遷移させる関数
function redirect($path)
{
    if ($path === GO_HOME) {
        $path = get_url('');
    } elseif ($path === GO_REFERER) {
        $path = $_SERVER['HTTP_REFERER'];
    } else {
        $path = get_url($path);
    }

    header("Location: {$path}");
    die();
}


// 小文字か大文字の半角英字もしくは数字にマッチするかどうかを判定する関数
function is_alnum($val)
{
    return preg_match("/^[a-zA-Z0-9]+$/", $val);
}


// 再帰的プログラミングを用いたエスケープ処理
// 配列 → オブジェクト → 文字列と、中に中に入っていって
function escape($data)
{
    // 配列の場合
    if (is_array($data)) {
        foreach ($data as $prop => $val) {
            // ここの$valはオブジェクトなので次はelseifブロックに移る
            $data[$prop] = escape($val);
        }
        return $data;

        // オブジェクトの場合
    } elseif (is_object($data)) {
        foreach ($data as $prop => $val) {
            // ここの$valは文字列なので次はelseブロックに移る
            $data->$prop = escape($val);
        }
        return $data;

        // 配列でもオブジェクトでもない場合
    } else {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }


    // ページネーションの表示範囲を返す関数
    function getPaginationRange($current_page, $max_page)
    {
        if ($current_page === 1 || $current_page === $max_page) {
            $range = 4;
        } elseif ($current_page === 2 || $current_page === $max_page - 1) {
            $range = 3;
        } else {
            $range = 2;
        }

        return $range;
    }
}
