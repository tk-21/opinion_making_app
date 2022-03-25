<?php

namespace controller\logout;

use lib\Auth;
use lib\Msg;

// getでリクエストが来た場合
function get()
{
    // logoutメソッドでtrueが返ってきたらメッセージを格納する
    if (Auth::logout()) {
        Msg::push(Msg::INFO, 'ログアウトしました。');
        redirect('login');
    } else {
        Msg::push(Msg::ERROR, 'ログアウトに失敗しました。');
    }

}
