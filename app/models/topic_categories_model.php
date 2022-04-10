<?php

namespace model;

use lib\Msg;

class TopicCategoriesModel extends AbstractModel
{
    public $id;
    public $topic_id;
    public $category_id;
    // 先頭にアンダースコアがついていれば、何か特定のメソッドを通じて値を取得するものという意味
    // セッションの情報はメソッドを通じて取得してくださいという意味
    protected static $SESSION_NAME = '_topic_categories';


    // public static function validateId($id)
    // {

    //     if (empty($id) || !is_numeric($id)) {
    //         Msg::push(Msg::ERROR, 'パラメータが不正です。');
    //         return false;
    //     }

    //     return true;
    // }

    // public function isValidId()
    // {
    //     return static::validateId($this->id);
    // }



    // public static function validateOpinion($opinion)
    // {

    //     if (empty($opinion)) {
    //         Msg::push(Msg::ERROR, '意見を入力してください。');
    //         return false;
    //     }

    //     return true;
    // }

    // public function isValidOpinion()
    // {
    //     return static::validateOpinion($this->opinion);
    // }



    // public static function validateReason($reason)
    // {

    //     if (empty($reason)) {
    //         Msg::push(Msg::ERROR, '理由を入力してください。');
    //         return false;
    //     }

    //     return true;
    // }

    // public function isValidReason()
    // {
    //     return static::validateReason($this->reason);
    // }



    // public function isValidTopicId()
    // {
    //     return TopicModel::validateId($this->topic_id);
    // }
}
