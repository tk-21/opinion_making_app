<?php

require_once 'config.php';

// Library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';
require_once SOURCE_BASE . 'libs/router.php';

// model
require_once SOURCE_BASE . 'models/abstract_model.php';
require_once SOURCE_BASE . 'models/user_model.php';
require_once SOURCE_BASE . 'models/topic_model.php';
require_once SOURCE_BASE . 'models/objection_model.php';
require_once SOURCE_BASE . 'models/opinion_model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/db.php';
require_once SOURCE_BASE . 'db/user_query.php';
require_once SOURCE_BASE . 'db/topic_query.php';
require_once SOURCE_BASE . 'db/objection_query.php';
require_once SOURCE_BASE . 'db/counter_objection_query.php';

// partials
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';

// View
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/login.php';
require_once SOURCE_BASE . 'views/register.php';
// require_once SOURCE_BASE . 'views/topic/archive.php';
require_once SOURCE_BASE . 'views/detail.php';
// require_once SOURCE_BASE . 'views/topic/edit.php';

// controllerのファイルはrouter.php内で自動的に読み込まれるので、ここに記述する必要はない

use function lib\route;

session_start();

try {
    // ヘッダーを共通化して読み込み
    // \partials\header();

    // pathの部分のみを取り出し、スラッシュを除く処理
    $path = str_replace('/', '', parse_url(CURRENT_URI, PHP_URL_PATH));

    // リクエストメソッドを小文字に変換して取得
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    // 渡ってくるパスによってコントローラーを呼び分ける
    // getかpostかによって実行されるメソッドが変わる
    route($path, $method);

    // フッターを共通化して読み込み
    // \partials\footer();
} catch (Throwable $e) {
    // 処理を止める
    die('<h1>何かがすごくおかしいようです。</h1>');
}


// リクエストをまたいでエラーが発生したかどうかというのを処理する場合はセッションを使って値を保持する必要がある
