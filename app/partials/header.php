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
        <title>在手賀産業株式会社</title>
        <meta name="description" content="{ページの説明文}" />
        <!--OGPの設定-->
        <meta property="og:title" content="在手賀産業株式会社" />
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
        <header class="header">
            <h1 class="header-logo">
                <a href="#"><img src="svg/logo.svg" alt="" />
                    在手賀産業株式会社
                </a>
            </h1>
            <nav class="gnav">
                <ul class="gnav-list">
                    <li class="gnav-item _sub">
                        <a href="">会社案内</a>
                        <nav class="subnav">
                            <div class="subnav-inner">
                                <div class="subnav-head">
                                    <h3 class="subnav-ttl">会社案内</h3>
                                    <p class="subnav-txt">
                                        在手賀産業が扱う商品は多岐に渡ります。
                                        そんな弊社の情報を細かくお伝えします。
                                    </p>
                                    <a href="#" class="view-btn">View more</a>
                                </div>
                                <ul class="subnav-list">
                                    <li class="subnav-item">
                                        <a href="#">
                                            <figure class="subnav-pic">
                                                <img src="img/vision.png" alt="" />
                                            </figure>
                                            <span>ビジョン</span>
                                        </a>
                                    </li>
                                    <li class="subnav-item">
                                        <a href="#">
                                            <figure class="subnav-pic">
                                                <img src="img/vision.png" alt="" />
                                            </figure>
                                            <span>会社概要</span>
                                        </a>
                                    </li>
                                    <li class="subnav-item">
                                        <a href="#">
                                            <figure class="subnav-pic">
                                                <img src="img/vision.png" alt="" />
                                            </figure>
                                            <span>沿革</span>
                                        </a>
                                    </li>
                                    <li class="subnav-item">
                                        <a href="#">
                                            <figure class="subnav-pic">
                                                <img src="img/vision.png" alt="" />
                                            </figure>
                                            <span>代表あいさつ</span>
                                        </a>
                                    </li>
                                    <li class="subnav-item">
                                        <a href="#">
                                            <figure class="subnav-pic">
                                                <img src="img/vision.png" alt="" />
                                            </figure>
                                            <span>メンバー</span>
                                        </a>
                                    </li>
                                    <li class="subnav-item">
                                        <a href="#">
                                            <figure class="subnav-pic">
                                                <img src="img/vision.png" alt="" />
                                            </figure>
                                            <span>主要取引先一覧</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <nav class="spsubnav">
                            <ul class="spsubnav-list">
                                <li class="spsubnav-item">
                                    <a href="#">ビジョン</a>
                                </li>
                                <li class="spsubnav-item">
                                    <a href="#">会社概要</a>
                                </li>
                                <li class="spsubnav-item">
                                    <a href="#">沿革</a>
                                </li>
                                <li class="spsubnav-item">
                                    <a href="#">代表あいさつ</a>
                                </li>
                                <li class="spsubnav-item">
                                    <a href="#">メンバー</a>
                                </li>
                                <li class="spsubnav-item">
                                    <a href="#">主要取引先一覧</a>
                                </li>
                            </ul>
                        </nav>
                    </li>
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



    <!-- <body>
        <div id="container">
            <header class="container my-2">
                <nav class="row align-items-center py-2">
                    <a href="<?php the_url('/'); ?>" class="col-md d-flex align-items-center mb-3 mb-md-0">
                        <img width="50" class="mr-2" src="../public/img/logo.svg" alt="みんなのアンケート　サイトロゴ">
                        <span class="h2 font-weight-bold mb-0">みんなのアンケート</span>
                    </a>
                    <div class="col-md-auto">

                        <?php //ユーザーから見えないようにするため、コメントを入れるときはphpタグで囲って入れる
                        ?>
                        <?php //ログインされていたらtrueが返ってくるので、if文の中が実行される
                        ?>
                        <?php if (Auth::isLogin()) : ?>
                            <!-- ログインしているとき -->
                            <!-- <a href="<?php the_url('topic/create'); ?>" class="btn btn-primary mr-2">投稿</a>
                            <a href="<?php the_url('topic/archive'); ?>" class="mr-2">過去の投稿</a>
                            <a href="<?php the_url('logout'); ?>">ログアウト</a> -->
                        <?php else : ?>
                            <!-- <a href="<?php the_url('register'); ?>" class="btn btn-primary mr-2">登録</a>
                            <a href="<?php the_url('login'); ?>">ログイン</a> -->
                        <?php endif; ?>

                    <!-- </div>
                </nav>
            </header> -->
            <!-- <main class="container py-3"> -->

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
