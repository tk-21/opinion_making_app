<?php

namespace view\home;

use lib\Auth;
use lib\Msg;

// 引数でトピックの配列が渡ってくる
function index()
{
?>
    <!-- <ul class="container"> -->
    <?php
    // 一つずつの投稿がtopic_list_itemに渡って、リストが形成される
    // foreach ($topics as $topic) {
    // idをキーにしてtopicの詳細画面に飛ぶようにする
    // このURLを引数として渡す
    // $url = get_url('topic/detail?topic_id=' . $topic->id);
    // \partials\topic_list_item($topic, $url, false);
    // }
    ?>
    <!-- </ul> -->

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
                    <a href="#"><img src="svg/logo.svg" alt="" />
                        在手賀産業株式会社
                    </a>
                </h1>
                <nav class="gnav">
                    <ul class="gnav-list">
                        <li class="gnav-item"><a href="">会社案内</a></li>
                        <li class="gnav-item"><a href="">お知らせ</a></li>
                        <li class="gnav-item"><a href="">事業内容</a></li>
                        <li class="gnav-item"><a href="">実績紹介</a></li>
                        <li class="gnav-item"><a href="">ブログ</a></li>
                        <li class="gnav-item"><a href="">求人情報</a></li>
                    </ul>
                    <a href="#" class="contact-btn">お問い合わせ</a>
                </nav>
                <div class="open-btn"><span></span><span></span><span></span></div>
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
                ?>


                <article class="topic" id="topic">
                    <!-- <ul class="circle-list">
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
            <li class="circle-item"></li>
        </ul> -->

                    <div class="inner">
                        <h2 class="topic-ttl">トピック一覧</h2>
                        <ul class="topic-list">
                            <li class="topic-item">
                                <a href="#">
                                    <div class="topic-body">
                                        <time datetime="2021-06-21">2021.06.21</time>
                                        <p class="topic-txt">
                                            弊社のビジョンと創業時からの企業ステートメント。
                                        </p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <a href="#" class="detail-btn">詳しく見る
                            <img src="svg/arrow-black.svg" alt="" />
                        </a>
                    </div>

                </article>


            <?php
        }
            ?>
