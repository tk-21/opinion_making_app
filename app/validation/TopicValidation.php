<?php

namespace validation;

use lib\Msg;

class TopicValidation
{
    public $data = [];

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }


    public function check()
    {
        if (
            !($this->validateTitle() *
                $this->validateBody() *
                $this->validatePosition() *
                $this->validateCategoryId())
        ) {
            return false;
        }

        return true;
    }


    public function validateTitle()
    {
        if (isset($this->data['title']) && empty($this->data['title'])) {
            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            return false;
        }

        return true;
    }

    public function validateBody()
    {
        if (isset($this->data['body']) && empty($this->data['body'])) {
            Msg::push(Msg::ERROR, '本文を入力してください。');
            return false;
        }

        return true;
    }

    public function validatePosition()
    {
        if (isset($this->data['position']) && empty($this->data['position'])) {
            Msg::push(Msg::ERROR, 'ポジションを入力してください。');
            return false;
        }

        return true;
    }

    public function validateCategoryId()
    {
        if (isset($this->data['category_id']) && empty($this->data['category_id'])) {
            Msg::push(Msg::ERROR, 'カテゴリーを選択してください。');
            return false;
        }

        return true;
    }
}
