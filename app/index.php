<?php

require_once 'config.php';

// Library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';
require_once SOURCE_BASE . 'libs/router.php';

// model
require_once SOURCE_BASE . 'models/abstract.model.php';
require_once SOURCE_BASE . 'models/user.model.php';
require_once SOURCE_BASE . 'models/topic.model.php';
// require_once SOURCE_BASE . 'models/comment.model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/db.php';
require_once SOURCE_BASE . 'db/user.query.php';
require_once SOURCE_BASE . 'db/topic.query.php';
// require_once SOURCE_BASE . 'db/comment.query.php';

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

    // 以下、動的にコントローラーを呼び出すための処理

    // CURRENT_URIからスラッシュを取り除く
    $path = parse_url(CURRENT_URI, PHP_URL_PATH);
    $path = str_replace(BASE_PATH, '', $path);

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
