<?php

namespace router;

use controllers\AuthController;
use controllers\CategoryController;
use controllers\HomeController;
use controllers\TopicController;
use controllers\OpinionController;
use controllers\DetailController;
use controllers\ResetController;


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

            case 'category_edit':
                $category = new CategoryController;
                $category->showEditForm();
                break;

            case 'category_delete':
                $category = new CategoryController;
                $category->confirmDelete();
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

            case 'objection_edit':
                $detail = new DetailController;
                $detail->showEditForm();
                break;

            case 'opinion_create':
                $opinion = new OpinionController;
                $opinion->showCreateForm();
                break;

            case 'opinion_edit':
                $opinion = new OpinionController;
                $opinion->showEditForm();
                break;

            case 'request':
                $reset = new ResetController;
                $reset->showRequestForm();
                break;

            case 'email_sent':
                $reset = new ResetController;
                $reset->showEmailSent();
                break;

            case 'reset':
                $reset = new ResetController;
                $reset->showResetForm();
                break;

            default:
                require_once SOURCE_BASE . 'views/404.php';
        }
    }


    public static function post($path)
    {
        switch ($path) {
            case '':
                $category = new CategoryController;
                $category->createCategory();
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
                $detail->create();
                break;

            case 'category_edit':
                $category = new CategoryController;
                $category->edit();
                break;

            case 'category_delete':
                $category = new CategoryController;
                $category->delete();
                break;

            case 'objection_delete':
                $detail = new DetailController;
                $detail->delete();
                break;

            case 'topic_create':
                $topic = new TopicController;
                $topic->create();
                break;

            case 'topic_edit':
                $topic = new TopicController;
                $topic->edit();
                break;

            case 'update_status':
                $topic = new TopicController;
                $topic->updateStatus();
                break;

            case 'topic_delete':
                $topic = new TopicController;
                $topic->delete();
                break;

            case 'objection_edit':
                $detail = new DetailController;
                $detail->edit();
                break;

            case 'opinion_create':
                $opinion = new OpinionController;
                $opinion->create();
                break;

            case 'opinion_edit':
                $opinion = new OpinionController;
                $opinion->edit();
                break;

            case 'request':
                $reset = new ResetController;
                $reset->request();
                break;

            case 'reset':
                $reset = new ResetController;
                $reset->reset();
                break;

            default:
                require_once SOURCE_BASE . 'views/404.php';
        }
    }
}
