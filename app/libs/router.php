<?php

namespace lib;

use controllers\AuthController;
use controllers\HomeController;
use controllers\TopicController;
use controllers\OpinionController;
use controllers\DetailController;


class Router
{
    public static function get($path)
    {
        switch ($path) {
            case '':
            case 'home':
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
                $home->showTopicsByCategory();
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
    }


    public static function post($path)
    {
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
                    return;
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
    }
}
