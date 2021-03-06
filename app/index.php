<?php

use router\Router;
use lib\Msg;

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
require_once SOURCE_BASE . 'views/detail.php';
require_once SOURCE_BASE . 'views/topic.php';
require_once SOURCE_BASE . 'views/opinion.php';


session_start();

try {
    // ????????????????????????????????????????????????????????????
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    // path??????????????????????????????????????????????????????????????????
    $path = str_replace('/', '', parse_url(CURRENT_URI, PHP_URL_PATH));

    // ???????????????????????????????????????????????????????????????
    if ($method === 'get') {
        Router::get($path);
        return;
    }

    if ($method === 'post') {
        Router::post($path);
        return;
    }
} catch (Exception $e) {
    // ??????????????????????????????????????????????????????????????????
    Msg::push(Msg::DEBUG, $e->getMessage());
    Msg::push(Msg::ERROR, '????????????????????????????????????');
    // 404?????????????????????
    require_once SOURCE_BASE . 'views/404.php';
}
