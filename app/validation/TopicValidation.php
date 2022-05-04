<?php

namespace validation;

use lib\Msg;

class TopicValidation
{
    public function validateId($topic)
    {
        if (empty($topic->id) || !is_numeric($topic->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }


    public function validateTitle($topic)
    {
        if (empty($topic->title)) {
            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            return false;
        }

        return true;
    }


    public function validateBody($topic)
    {
        if (empty($topic->body)) {
            Msg::push(Msg::ERROR, '本文を入力してください。');
            return false;
        }

        return true;
    }


    public function validatePosition($topic)
    {
        if (empty($topic->position)) {
            Msg::push(Msg::ERROR, 'ポジションを入力してください。');
            return false;
        }

        return true;
    }


    public static function validateStatus($topic)
    {
        if ($topic->complete_flg > 1 || $topic->complete_flg < 0) {
            Msg::push(Msg::ERROR, 'ステータスの値が不正です。');
            return false;
        }

        return true;
    }


    public function validateCategoryId($topic)
    {
        if (empty($topic->category_id)) {
            Msg::push(Msg::ERROR, 'カテゴリーを選択してください。');
            return false;
        }

        return true;
    }


    // トピック作成のときに実行するメソッド
    public function checkCreate($topic)
    {
        if (
            !($this->validateTitle($topic) *
                $this->validateBody($topic) *
                $this->validatePosition($topic))
        ) {
            return false;
        }

        return true;
    }


    // トピック編集のときに実行するメソッド
    public function checkEdit($topic)
    {
        if (
            !($this->validateId($topic) *
                $this->validateTitle($topic) *
                $this->validateBody($topic) *
                $this->validatePosition($topic) *
                $this->validateStatus($topic))
        ) {
            return false;
        }

        return true;
    }
}
