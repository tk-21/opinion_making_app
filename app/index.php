<?php

require_once 'config.php';

// controller
require_once SOURCE_BASE . 'controllers/AuthController.php';
require_once SOURCE_BASE . 'controllers/DetailController.php';
require_once SOURCE_BASE . 'controllers/HomeController.php';
require_once SOURCE_BASE . 'controllers/OpinionController.php';
require_once SOURCE_BASE . 'controllers/TopicController.php';

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
require_once SOURCE_BASE . 'models/category_model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/db.php';
require_once SOURCE_BASE . 'db/user_query.php';
require_once SOURCE_BASE . 'db/topic_query.php';
require_once SOURCE_BASE . 'db/objection_query.php';
require_once SOURCE_BASE . 'db/counter_objection_query.php';
require_once SOURCE_BASE . 'db/opinion_query.php';
require_once SOURCE_BASE . 'db/category_query.php';

// partials
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';

// View
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/auth.php';
require_once SOURCE_BASE . 'views/detail.php';
require_once SOURCE_BASE . 'views/topic.php';
require_once SOURCE_BASE . 'views/opinion.php';


use function lib\route;

session_start();

try {
    // ヘッダーを共通化して読み込み
    // \partials\header();

    // pathの部分のみを取り出し、前後のスラッシュを除く
    $path = trim(parse_url(CURRENT_URI, PHP_URL_PATH), '/');

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
