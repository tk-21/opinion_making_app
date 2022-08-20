<?php

namespace validation;

use lib\Msg;

class TopicValidation
{
    private $topic;

    public function __construct($topic)
    {
        $this->topic = $topic;
    }

    public function getValidData()
    {
        return $this->topic;
    }


    public function validateId()
    {
        if (empty($this->topic->id) || !is_numeric($this->topic->id)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            return false;
        }

        return true;
    }


    public function validateTitle()
    {
        if (empty($this->topic->title)) {
            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            return false;
        }

        return true;
    }


    public function validateBody()
    {
        if (empty($this->topic->body)) {
            Msg::push(Msg::ERROR, '本文を入力してください。');
            return false;
        }

        return true;
    }


    public function validatePosition()
    {
        if (empty($this->topic->position)) {
            Msg::push(Msg::ERROR, 'ポジションを入力してください。');
            return false;
        }

        return true;
    }


    public function validateStatus()
    {
        if ($this->topic->complete_flg > 1 || $this->topic->complete_flg < 0) {
            Msg::push(Msg::ERROR, 'ステータスの値が不正です。');
            return false;
        }

        return true;
    }


    public function validateCategoryId()
    {
        if (empty($this->topic->category_id)) {
            Msg::push(Msg::ERROR, 'カテゴリーを選択してください。');
            return false;
        }

        return true;
    }


    // トピック作成のときに実行するメソッド
    public function checkCreate()
    {
        if (
            !($this->validateTitle() *
                $this->validateBody() *
                $this->validatePosition())
        ) {
            return false;
        }

        return true;
    }


    // トピック編集のときに実行するメソッド
    public function checkEdit()
    {
        if (
            !($this->validateId() *
                $this->validateTitle() *
                $this->validateBody() *
                $this->validatePosition())
        ) {
            return false;
        }

        return true;
    }
}
