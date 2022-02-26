<?php

require_once 'config.php';

// Library
require_once SOURCE_BASE . 'libs/helper.php';
require_once SOURCE_BASE . 'libs/auth.php';
require_once SOURCE_BASE . 'libs/router.php';

// model
require_once SOURCE_BASE . 'models/abstract.model.php';
require_once SOURCE_BASE . 'models/user.model.php';
require_once SOURCE_BASE . 'models/topic.model.php';
require_once SOURCE_BASE . 'models/comment.model.php';

// Message
require_once SOURCE_BASE . 'libs/message.php';

// DB
require_once SOURCE_BASE . 'db/datasource.php';
require_once SOURCE_BASE . 'db/user.query.php';
require_once SOURCE_BASE . 'db/topic.query.php';
require_once SOURCE_BASE . 'db/comment.query.php';

// partials
require_once SOURCE_BASE . 'partials/topic-list-item.php';
require_once SOURCE_BASE . 'partials/topic-header-item.php';
require_once SOURCE_BASE . 'partials/header.php';
require_once SOURCE_BASE . 'partials/footer.php';

// View
require_once SOURCE_BASE . 'views/home.php';
require_once SOURCE_BASE . 'views/login.php';
require_once SOURCE_BASE . 'views/register.php';
require_once SOURCE_BASE . 'views/topic/archive.php';
require_once SOURCE_BASE . 'views/topic/detail.php';
require_once SOURCE_BASE . 'views/topic/edit.php';

// controllerのファイルはrouter.php内で自動的に読み込まれるので、ここに記述する必要はない

use function lib\route;

session_start();

try {
    // ヘッダーとフッターを共通化して読み込み
    \partials\header();

    // 動的にコントローラーを呼び出す処理

    // $_SERVER['REQUEST_URI']で渡ってきたURLを分ける
    $url = parse_url(CURRENT_URI);

    // $url['path']でパスの部分だけ取ってきたURLから、BASE_CONTEXT_PATHに一致する文字列（app/までのURL）を空文字で置き換える（取り除く）
    $rpath = str_replace(BASE_CONTEXT_PATH, '', $url['path']);

    // リクエストメソッドを小文字に変換して取得
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    // 渡ってくるパスによってコントローラーを呼び分ける
    // getかpostかによって実行されるメソッドが変わる
    route($rpath, $method);

    \partials\footer();
} catch (Throwable $e) {
    // 処理を止める
    die('<h1>何かがすごくおかしいようです。</h1>');
}




// リクエストをまたいでエラーが発生したかどうかというのを処理する場合はセッションを使って値を保持する必要がある
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
    <link rel="stylesheet" href="../css/style.min.css" />
    <!-- プラグインのcss -->
    <!-- jQuery本体 -->
    <script src="js/jquery.min.js"></script>
    <!-- jQueryプラグイン -->
    <script src="js/parallax.min.js"></script>
    <script src="js/jquery-modal-video.min.js"></script>
    <!-- script.js -->
    <script src="js/script.js"></script>
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
        <section class="fv">
            <div class="fv-inner">
                <p class="fv-txt">
                    人と組織の事業課題を<br />
                    最先端テクノロジーで解決する
                </p>
                <a href="#" class="view-btn _white">MISSION</a>
            </div>
            <ul class="fv-link">
                <li class="fv-item _left">
                    <a href="#news">
                        <span>NEWS</span>
                        <span>最新情報</span>
                    </a>
                </li>
                <li class="fv-item">
                    <a href="#blog">
                        <span>BLOG</span>
                        <span>ブログ</span></a>
                </li>
            </ul>
            <div class="fv-scroll"></div>
        </section>

        <section class="about">
            <div class="about-movie">
                <h2 class="about-ttl">WHO WE ARE</h2>
                <div class="movie-btn">
                    <span>MOVIE</span>
                    <a href="javascript:void(0);" data-video-id="ZIVAHlxS1i8" class="js-modal-video"><img src="svg/triangle.svg" alt="" /></a>
                </div>
            </div>
            <div class="inner">
                <div class="about-head">
                    <p class="about-copy">人類の豊かさを大きく創造する未来へ。</p>
                    <p class="about-txt">
                        IOTインテグレーションから未来を想像し、既存の事業課題を解決します。<br />
                        私たちは組織の価値をデータから導き出し、再発明するイノベーションカンパニーです。
                    </p>
                </div>
                <ul class="about-list">
                    <li class="about-item">
                        <a href="#">
                            <figure class="about-pic">
                                <img src="img/vision.png" alt="" />
                            </figure>
                            <p class="about-heading">VISION</p>
                        </a>
                        <p class="about-txt">
                            弊社のビジョンと創業時からの企業ステートメント。
                        </p>
                    </li>
                    <li class="about-item">
                        <a href="#">
                            <figure class="about-pic">
                                <img src="img/message.png" alt="" />
                            </figure>
                            <p class="about-heading">MESSAGE</p>
                        </a>
                        <p class="about-txt">代表・佐藤からのあいさつです。</p>
                    </li>
                    <li class="about-item">
                        <a href="#">
                            <figure class="about-pic">
                                <img src="img/profile.png" alt="" />
                            </figure>
                            <p class="about-heading">PROFILE</p>
                        </a>
                        <p class="about-txt">会社概要と沿革について。</p>
                    </li>
                </ul>
                <a href="" class="detail-btn">詳しく見る
                    <img src="svg/arrow-black.svg" alt="" />
                </a>
            </div>
        </section>

        <section class="news" id="news">
            <div class="inner">
                <h2 class="ttl-en">NEWS</h2>
                <p class="ttl-jp">最新情報</p>
                <nav class="ntab">
                    <ul class="ntab-list">
                        <li class="ntab-item active"><a href="#tab1">お知らせ</a></li>
                        <li class="ntab-item"><a href="#tab2">プレリリース</a></li>
                        <li class="ntab-item"><a href="#tab3">キャリア</a></li>
                        <li class="ntab-item"><a href="#tab4">メディア掲載</a></li>
                    </ul>
                </nav>
                <ul class="news-list active" id="tab1">
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">お知らせ</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">お知らせ</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">お知らせ</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                </ul>
                <ul class="news-list" id="tab2">
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">プレリリース</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">プレリリース</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">プレリリース</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                </ul>
                <ul class="news-list" id="tab3">
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">キャリア</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">キャリア</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">キャリア</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                </ul>
                <ul class="news-list" id="tab4">
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">メディア掲載</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">メディア掲載</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                    <li class="news-item">
                        <div class="news-header">
                            <time datetime="2020-12-20">2020.12.20</time><a href="#">メディア掲載</a>
                        </div>
                        <div class="news-body">
                            <a href="#">地球規模の医薬品産業は世界で巨大な市場規模を有し、今後も成長が予測される市場であると言われています。
                                わたしたちは、今までに無い研究開発を行う創薬バイオベンチャー企業です。</a>
                        </div>
                    </li>
                </ul>
                <a href="#" class="detail-btn">詳しく見る
                    <img src="svg/arrow-black.svg" alt="" />
                </a>
            </div>
        </section>

        <section class="service">
            <div class="inner">
                <h2 class="ttl-en">SERVICE</h2>
                <p class="ttl-jp">事業内容</p>
                <div class="media">
                    <figure class="media-pic">
                        <img src="img/service1.png" alt="" />
                    </figure>
                    <div class="media-body">
                        <h3 class="media-ttl">画像処理技術開発</h3>
                        <p class="media-txt">
                            在手賀産業株式会社では、画像処理技術を用いた
                            様々な製品の開発に携わっています。可視、赤外
                            等の各種カメラから得られた映像信号を基に、プ
                            ログラムの開発、各種試験を行っています。
                        </p>
                        <a href="#" class="view-btn">View more</a>
                    </div>
                </div>
                <div class="media">
                    <figure class="media-pic">
                        <img src="img/service2.png" alt="" />
                    </figure>
                    <div class="media-body">
                        <h3 class="media-ttl">都市データ活用事業</h3>
                        <p class="media-txt">
                            在手賀産業株式会社では、画像処理技術を用いた
                            様々な製品の開発に携わっています。可視、赤外
                            等の各種カメラから得られた映像信号を基に、プ
                            ログラムの開発、各種試験を行っています。
                        </p>
                        <a href="#" class="view-btn">View more</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="vr">
            <div class="inner">
                <ul class="vr-list">
                    <li class="vr-item _left">
                        <a href="#">画像認識処理とVR開発</a>
                    </li>
                    <li class="vr-item _center">
                        <a href="#">画像認識処理とVR開発</a>
                    </li>
                    <li class="vr-item _right">
                        <a href="#">画像認識処理とVR開発</a>
                    </li>
                </ul>
            </div>
        </section>

        <section class="works" data-parallax="scroll" data-image-src="img/works-bg.png">
            <div class="inner">
                <h2 class="ttl-en">WORKS</h2>
                <p class="ttl-jp">実績紹介</p>
                <ul class="works-list">
                    <li class="works-item">
                        <a href="#">
                            <figure class="works-pic">
                                <img src="img/works1.png" alt="" />
                            </figure>
                            <p class="works-txt">画像認識処理とVR開発</p>
                        </a>
                    </li>
                    <li class="works-item">
                        <a href="#">
                            <figure class="works-pic">
                                <img src="img/works2.png" alt="" />
                            </figure>
                            <p class="works-txt">
                                当社ICT関連サービスの音声認識ソフト。高速道路での運用開始
                            </p>
                        </a>
                    </li>
                    <li class="works-item">
                        <a href="#">
                            <figure class="works-pic">
                                <img src="img/works3.png" alt="" />
                            </figure>
                            <p class="works-txt">
                                RPAを促進するデータインキュベーション
                            </p>
                        </a>
                    </li>
                </ul>
                <a href="#" class="detail-btn _white">詳しく見る
                    <img src="/svg/arrow-white.svg" alt="" />
                </a>
            </div>
        </section>

        <section class="client">
            <div class="inner">
                <h2 class="client-ttl">OUR CLIENT</h2>
                <div class="client-wrapper">
                    <ul class="client-list _upper">
                        <li class="client-item _left">
                            <figure class="client-pic">
                                <img src="svg/denso.svg" alt="" />
                            </figure>
                        </li>
                        <li class="client-item _center">
                            <figure class="client-pic">
                                <img src="svg/Zenrin.svg" alt="" />
                            </figure>
                        </li>
                        <li class="client-item _right">
                            <figure class="client-pic">
                                <img src="svg/jins.svg" alt="" />
                            </figure>
                        </li>
                    </ul>
                    <ul class="client-list _lower">
                        <li class="client-item _left">
                            <figure class="client-pic">
                                <img src="svg/honda.svg" alt="" />
                            </figure>
                        </li>
                        <li class="client-item _center">
                            <figure class="client-pic">
                                <img src="svg/sompo.svg" alt="" />
                            </figure>
                        </li>
                        <li class="client-item _right">
                            <figure class="client-pic">
                                <img src="svg/round1.svg" alt="" />
                            </figure>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <article class="blog" id="blog">
            <div class="inner">
                <h2 class="ttl-en">BLOG</h2>
                <p class="ttl-jp">ブログ</p>
                <ul class="blog-list">
                    <li class="blog-item">
                        <a href="#">
                            <figure class="blog-pic">
                                <img src="img/blog1.png" alt="" />
                            </figure>
                            <div class="blog-body">
                                <time datetime="2021-06-21">2021.06.21</time>
                                <p class="blog-txt">
                                    弊社のビジョンと創業時からの企業ステートメント。
                                </p>
                            </div>
                        </a>
                    </li>
                    <li class="blog-item">
                        <a href="#">
                            <figure class="blog-pic">
                                <img src="img/blog2.png" alt="" />
                            </figure>
                            <div class="blog-body">
                                <time datetime="2021-06-21">2021.06.21</time>
                                <p class="blog-txt">代表・佐藤からのごあいさつです。</p>
                            </div>
                        </a>
                    </li>
                    <li class="blog-item">
                        <a href="#">
                            <figure class="blog-pic">
                                <img src="img/blog3.png" alt="" />
                            </figure>
                            <div class="blog-body">
                                <time datetime="2021-06-21">2021.06.21</time>
                                <p class="blog-txt">会社概要と沿革について。</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <a href="#" class="detail-btn">詳しく見る
                    <img src="svg/arrow-black.svg" alt="" />
                </a>
            </div>
        </article>

        <section class="link">
            <div class="inner">
                <ul class="link-list">
                    <li class="link-item">
                        <a href="#">
                            <p class="link-txt _en">RECRUIT</p>
                            <p class="link-txt _jp">求人情報</p>
                        </a>
                    </li>
                    <li class="link-item">
                        <a href="#">
                            <p class="link-txt _en">CONTACT</p>
                            <p class="link-txt _jp">お問い合わせ</p>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="inner">
            <div class="footer-upper">
                <p class="footer-logo">
                    <a href="#"><img src="svg/logo.svg" alt="" />
                        在手賀産業株式会社
                    </a>
                </p>
                <div class="footer-info">
                    <p class="footer-txt _company">株式会社 在手賀産業株式会社</p>
                    <p class="footer-txt _address">
                        <span>〒111-0022</span>東京都新宿区真直一手右側<br />東京都新宿区真直一手右側
                    </p>
                    <p class="footer-txt _time">
                        営業時間：フリーテキストフリーテキストフリーテキストフリーテキスト
                    </p>
                    <p class="footer-txt">
                        営業時間：フリーテキストフリーテキストフリーテキストフリーテキスト
                    </p>
                </div>
                <div class="footer-sns">
                    <a href="#">TWITTER</a>
                    <a href="#">INSTAGRAM</a>
                    <a href="#">FACEBOOK</a>
                </div>
            </div>

            <nav class="fnav">
                <ul class="fnav-list">
                    <li class="fnav-item">
                        <a href="" class="fnav-ttl">会社案内</a>
                        <ul class="sublist">
                            <li class="sublist-item"><a href="#">代表挨拶</a></li>
                            <li class="sublist-item"><a href="#">コンセプト</a></li>
                        </ul>
                    </li>
                    <li class="fnav-item">
                        <a href="#" class="fnav-ttl">お知らせ</a>
                        <ul class="sublist">
                            <li class="sublist-item"><a href="#">カテゴリ01</a></li>
                            <li class="sublist-item"><a href="#">カテゴリ02</a></li>
                            <li class="sublist-item"><a href="#">カテゴリ03</a></li>
                        </ul>
                    </li>
                    <li class="fnav-item">
                        <a href="#" class="fnav-ttl">事業内容</a>
                        <ul class="sublist">
                            <li class="sublist-item"><a href="#">こんな事業01</a></li>
                            <li class="sublist-item"><a href="#">こんな事業02</a></li>
                            <li class="sublist-item"><a href="#">こんな事業03</a></li>
                        </ul>
                    </li>
                    <li class="fnav-item">
                        <a href="#" class="fnav-ttl">実績紹介</a>
                    </li>
                    <li class="fnav-item">
                        <a href="#" class="fnav-ttl">求人情報</a>
                        <ul class="sublist">
                            <li class="sublist-item"><a href="#">中途採用</a></li>
                            <li class="sublist-item"><a href="#">新規採用</a></li>
                            <li class="sublist-item"><a href="#">アルバイト</a></li>
                        </ul>
                    </li>
                    <li class="fnav-item">
                        <a href="#" class="fnav-ttl">ブログ</a>
                        <ul class="sublist">
                            <li class="sublist-item"><a href="#">カテゴリ01</a></li>
                            <li class="sublist-item"><a href="#">カテゴリ02</a></li>
                            <li class="sublist-item"><a href="#">カテゴリ03</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="footer-lower">
                <ul class="footer-list _left">
                    <li class="footer-item"><a href="#">プライバシーポリシー</a></li>
                    <li class="footer-item"><a href="#">サステナビリティ</a></li>
                    <li class="footer-item"><a href="#">CSR活動</a></li>
                    <li class="footer-item"><a href="#">ガバナンス</a></li>
                </ul>
                <ul class="footer-list _right">
                    <li>
                        <a href="https://privacymark.jp/" target="_blank" rel="noopener noreferrer"><img src="svg/privacy.svg" alt="" /></a>
                    </li>
                    <li>
                        <a href="https://www.jadma.or.jp/" target="_blank" rel="noopener noreferrer"><img src="svg/jadma.svg" alt="" /></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p class="copyright-txt">© 2020 COPY LIGHT ARUTEGA</p>
        </div>
    </footer>
</body>

</html>
