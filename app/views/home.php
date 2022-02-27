<?php

namespace view\home;

// 引数でトピックの配列が渡ってくる
function index()
{
    // 配列の先頭だけ切り出す
    // $topicsの配列の一番最初だけ$topicに入り、残りのものは$topicsに格納される
    // $topic = array_shift($topics);

    // 一番最初の値だけtopic_header_itemで表示し、残りはtopic_list_itemで表示するようにしている
    // \partials\topic_header_item($topic, true);
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

<?php
}
?>
