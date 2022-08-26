<?php

use router\Router;
use lib\Msg;

require_once 'config.php';

// controller
require_once SOURCE_BASE . 'controllers/AuthController.php';
require_once SOURCE_BASE . 'controllers/CategoryController.php';
require_once SOURCE_BASE . 'controllers/DetailController.php';
require_once SOURCE_BASE . 'controllers/HomeController.php';
require_once SOURCE_BASE . 'controllers/OpinionController.php';
require_once SOURCE_BASE . 'controllers/ResetController.php';
require_once SOURCE_BASE . 'controllers/TopicController.php';

// Library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';

// model
require_once SOURCE_BASE . 'models/abstract_model.php';
require_once SOURCE_BASE . 'models/category_model.php';
require_once SOURCE_BASE . 'models/objection_model.php';
require_once SOURCE_BASE . 'models/opinion_model.php';
require_once SOURCE_BASE . 'models/password_reset_model.php';
require_once SOURCE_BASE . 'models/topic_model.php';
require_once SOURCE_BASE . 'models/user_model.php';

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
require_once SOURCE_BASE . 'db/password_reset_query.php';

// partials
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';

// router
require_once SOURCE_BASE . 'router/Router.php';

// Validation
require_once SOURCE_BASE . 'validation/CategoryValidation.php';
require_once SOURCE_BASE . 'validation/ObjectionValidation.php';
require_once SOURCE_BASE . 'validation/OpinionValidation.php';
require_once SOURCE_BASE . 'validation/TopicValidation.php';
require_once SOURCE_BASE . 'validation/UserValidation.php';

// View
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/auth.php';
require_once SOURCE_BASE . 'views/category_edit.php';
require_once SOURCE_BASE . 'views/detail.php';
require_once SOURCE_BASE . 'views/topic.php';
require_once SOURCE_BASE . 'views/topic_delete.php';
require_once SOURCE_BASE . 'views/opinion.php';
require_once SOURCE_BASE . 'views/email_sent.php';
require_once SOURCE_BASE . 'views/request_form.php';
require_once SOURCE_BASE . 'views/reset_form.php';


session_start();

try {
    // リクエストメソッドを小文字に変換して取得
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    // pathの部分のみを取り出し、前後のスラッシュを除く
    $path = str_replace('/', '', parse_url(CURRENT_URI, PHP_URL_PATH));

    // メソッドとパスによって実行する処理を変える
    if ($method === 'get') {
        Router::get($path);
        return;
    }

    if ($method === 'post') {
        Router::post($path);
        return;
    }
} catch (Exception $e) {
    // デバッグで何が起こったか確認できるようにする
    Msg::push(Msg::DEBUG, $e->getMessage());
    Msg::push(Msg::ERROR, '何かがおかしいようです。');
    // 404ページにとばす
    require_once SOURCE_BASE . 'views/404.php';
}
