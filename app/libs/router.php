<?php

namespace lib;

use controllers\AuthController;
use controllers\HomeController;
use controllers\TopicController;
use controllers\OpinionController;
use controllers\DetailController;
use Exception;


class Router
{
    public static function get($path)
    {
        try {
            switch ($path) {
                case '':
                    $home = new HomeController;
                    $home->index();
                    break;

                case 'login':
                    $auth = new AuthController;
                    $auth->showLoginForm();
                    break;

                case 'logout':
                    $auth = new AuthController;
                    $auth->logout();
                    break;

                case 'register':
                    $auth = new AuthController;
                    $auth->showRegisterForm();
                    break;

                case 'detail':
                    $detail = new DetailController;
                    $detail->index();
                    break;

                case 'category':
                    $home = new HomeController;
                    $home->showTopicByCategory();
                    break;

                case 'topic_create':
                    $topic = new TopicController;
                    $topic->showCreateForm();
                    break;

                case 'topic_edit':
                    $topic = new TopicController;
                    $topic->showEditForm();
                    break;

                case 'topic_delete':
                    $topic = new TopicController;
                    $topic->confirmDelete();
                    break;

                case 'opinion_create':
                    $opinion = new OpinionController;
                    $opinion->showCreateForm();
                    break;

                case 'opinion_edit':
                    $opinion = new OpinionController;
                    $opinion->showEditForm();
                    break;

                default:
                    require_once SOURCE_BASE . 'views/404.php';
            }
        } catch (Exception $e) {
            // デバッグで何が起こったか確認できるようにする
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, '何かがおかしいようです。');
            // 404ページにとばす
            require_once SOURCE_BASE . 'views/404.php';
        }
    }


    public static function post($path)
    {
        try {
            switch ($path) {
                case '':
                    $home = new HomeController;
                    $home->createCategory();
                    break;

                case 'login':
                    $auth = new AuthController;
                    $auth->login();
                    break;

                case 'register':
                    $auth = new AuthController;
                    $auth->register();
                    break;

                case 'detail':
                    $detail = new DetailController;
                    $formType = get_param('form_type', null);

                    if ($formType === 'delete_objection' || 'delete_counterObjection') {
                        $detail->delete($formType);
                    }

                    if ($formType === 'create_objection' || 'create_counterObjection') {
                        $detail->create($formType);
                    }
                    break;

                case 'topic_create':
                    $topic = new TopicController;
                    $topic->create();
                    break;

                case 'topic_edit':
                    $topic = new TopicController;
                    $topic->edit();
                    break;

                case 'topic_delete':
                    $topic = new TopicController;
                    $topic->delete();
                    break;

                case 'opinion_create':
                    $opinion = new OpinionController;
                    $opinion->create();
                    break;

                case 'opinion_edit':
                    $opinion = new OpinionController;
                    $opinion->edit();
                    break;

                default:
                    require_once SOURCE_BASE . 'views/404.php';
            }
        } catch (Exception $e) {
            // デバッグで何が起こったか確認できるようにする
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, '何かがおかしいようです。');
            // 404ページにとばす
            require_once SOURCE_BASE . 'views/404.php';
        }
    }
}


// function route($path, $method)
// {

//     if ($path === '') {
//         $home = new HomeController;

//         if ($method === 'get') {
//             $home->index();
//         }
//         if ($method === 'post') {
//             $home->createCategory();
//         }
//     }


//     if ($path === 'login') {
//         $auth = new AuthController;

//         if ($method === 'get') {
//             $auth->showLoginForm();
//         }
//         if ($method === 'post') {
//             $auth->login();
//         }
//     }


//     if ($path === 'logout') {
//         $auth = new AuthController;
//         $auth->logout();
//     }


//     if ($path === 'register') {
//         $auth = new AuthController;

//         if ($method === 'get') {
//             $auth->showRegisterForm();
//         }
//         if ($method === 'post') {
//             $auth->register();
//         }
//     }


//     if ($path === 'detail') {
//         $detail = new DetailController;

//         if ($method === 'get') {
//             $detail->index();
//         }
//         if ($method === 'post') {
//             $formType = get_param('form_type', null);

//             if ($formType === 'delete_objection' || 'delete_counterObjection') {
//                 $detail->delete($formType);
//             }

//             if ($formType === 'create_objection' || 'create_counterObjection') {
//                 $detail->create($formType);
//             }
//         }
//     }


//     if ($path === 'category') {
//         $home = new HomeController;

//         if ($method === 'get') {
//             $home->showTopicByCategory();
//         }
//     }


//     if ($path === 'topic_create') {
//         $topic = new TopicController;

//         if ($method === 'get') {
//             $topic->showCreateForm();
//         }

//         if ($method === 'post') {
//             $topic->create();
//         }
//     }


//     if ($path === 'topic_edit') {
//         $topic = new TopicController;

//         if ($method === 'get') {
//             $topic->showEditForm();
//         }

//         if ($method === 'post') {
//             $topic->edit();
//         }
//     }


//     if ($path === 'opinion_create') {
//         $opinion = new OpinionController;

//         if ($method === 'get') {
//             $opinion->showCreateForm();
//         }

//         if ($method === 'post') {
//             $opinion->create();
//         }
//     }


//     if ($path === 'opinion_edit') {
//         $opinion = new OpinionController;

//         if ($method === 'get') {
//             $opinion->showEditForm();
//         }

//         if ($method === 'post') {
//             $opinion->edit();
//         }
//     }


//     if ($path === 'topic_delete') {
//         $topic = new TopicController;

//         if ($method === 'get') {
//             $topic->confirmDelete();
//         }

//         if ($method === 'post') {
//             $topic->delete();
//         }
//     }
// }

        // 渡ってきたパスによってコントローラー内のどれかのファイル名を取得
        // $targetFile = SOURCE_BASE . "controllers/{$path}.php";

        // コントローラー内に指定されたファイルが存在しなかったら404ページにとばす
        // if (!file_exists($targetFile)) {
        //     require_once SOURCE_BASE . 'views/404.php';
        //     return;
        // }

        // コントローラーの読み込み
        // require_once $targetFile;

        // 渡ってきたパスの途中にあるスラッシュをバックスラッシュに置き換える
        // $path = str_replace('/', '\\', $path);

        // パスとメソッドによって関数を呼び分ける
        // 渡ってきたパスとメソッドに応じてnamespace内の関数（getかpostか）を指定
        // fnはfunctionの略
        // $fn = "\\controller\\{$path}\\{$method}";

        // それを実行する
        // 文字列で定義したものであっても、関数が見つかれば、末尾に()をつけることによって実行できる
        // $fn();
