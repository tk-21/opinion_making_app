<?php

namespace view\login;

use lib\Auth;
use lib\Msg;

// HTMLを関数で囲んでおくと、その関数を呼んだときにHTMLの内容が出力されるようになる
function index()
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

                <section class="login">
                    <div class="auth-inner">
                        <form class="form validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate>
                            <h2 class="form-ttl">ログイン</h2>
                            <dl class="form-list">
                                <dt class="form-dttl"><label for="name" onclick="">ユーザーネーム</label></dt>
                                <dd class="form-item">
                                    <input type="text" name="name" class="form-text form-control validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                                    <div class="invalid-feedback"></div>
                                </dd>
                            </dl>
                            <dl class="form-list">
                                <dt class="form-dttl"><label for="password" onclick="">パスワード</label></dt>
                                <dd class="form-item">
                                    <input type="password" name="password" class="form-text form-control validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                                    <div class="invalid-feedback"></div>
                                </dd>
                            </dl>
                            <button type="submit" class="submit-btn">ログイン</button>
                            <div>
                                <a href="<?php the_url('register'); ?>">アカウント登録</a>
                            </div>
                        </form>
                    </div>
                </section>

            <?php
        }
            ?>
