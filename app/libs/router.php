<?php

namespace lib;

use controllers\HomeController;
use controllers\TopicController;
use controllers\OpinionController;
use Exception;


function route($path, $method)
{

    try {
        if ($path === '') {
            $home = new HomeController;

            if ($method === 'get') {
                $home->index();
            }
            if ($method === 'post') {
                $home->createCategory();
            }
        }


        if ($path === 'category') {
            $home = new HomeController;

            if ($method === 'get') {
                $home->showTopicByCategory();
            }
        }


        if ($path === 'topic_create') {
            $topic = new TopicController;

            if ($method === 'get') {
                $topic->showCreateForm();
            }

            if ($method === 'post') {
                $topic->create();
            }
        }


        if ($path === 'topic_edit') {
            $topic = new TopicController;

            if ($method === 'get') {
                $topic->showEditForm();
            }

            if ($method === 'post') {
                $topic->edit();
            }
        }


        if ($path === 'opinion_create') {
            $topic = new OpinionController;

            if ($method === 'get') {
                $topic->showCreateForm();
            }

            if ($method === 'post') {
                $topic->create();
            }
        }


        if ($path === 'opinion_edit') {
            $topic = new OpinionController;

            if ($method === 'get') {
                $topic->showEditForm();
            }

            if ($method === 'post') {
                $topic->edit();
            }


            if($path === 'detail') {
                
            }
        }


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
    } catch (Exception $e) {
        // デバッグで何が起こったか確認できるようにする
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, '何かがおかしいようです。');
        // 404ページにとばす
        redirect('404');
    }
}
