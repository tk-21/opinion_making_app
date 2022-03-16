<?php

namespace partials;

use lib\Auth;
use lib\Msg;

// 関数の形式にして、引数を渡せるようにしておく
function header()
{
?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>opinion_making_app</title>
        <meta name="description" content="{ページの説明文}" />
        <!--OGPの設定-->
        <meta property="og:title" content="opinion_making_app" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{サイトURL}" />
        <meta property="og:image" content="{OGP画像のURL}" />
        <meta property="og:site_name" content="{サイト名}" />
        <meta property="og:description" content="{サイトの説明文}" />
        <!--アイコンの設定-->
        <link rel="icon" href="{アイコンのパス}" />
        <link rel="apple-touch-icon" href="{アイコンのパス}" />
        <!--その他設定-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="format-detection" content="telephone=no" />
        <!-- フォントのcss -->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet" />
        <!-- style.css -->
        <link rel="stylesheet" href="../public/css/style.min.css" />
        <!-- プラグインのcss -->
    </head>

    <body>
        <!-- 背景ライン -->
        <div class="bg">
            <ul class="bg-line">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <div class="wrapper">
            <header class="header">
                <h1 class="header-logo">
                    <a href="<?php the_url('home'); ?>">
                        思考トレーニングアプリ
                    </a>
                </h1>
                <nav class="gnav">
                    <ul class="gnav-list">
                        <li class="gnav-item"><a href="<?php the_url('topic_edit'); ?>" class="create-btn">トピック作成</a></li>
                        <li class="gnav-item"><a href="<?php the_url('logout'); ?>" class="logout-btn">ログアウト</a></li>
                    </ul>
                </nav>
            </header>
            <main>

            <?php
            // ここで$_SESSION['_msg']にセットされた配列の値をループで表示している
            Msg::flush();

            if (Auth::isLogin()) {
                echo 'ログイン中です。';
            } else {
                echo 'ログインしていません。';
            }
        }
            ?>
