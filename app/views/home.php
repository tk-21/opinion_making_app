<?php

namespace view\home;


// 引数でトピックの配列が渡ってくる
function index()
{
    \partials\header();

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
    \partials\footer();
}
?>
