<?php

namespace view\home;

// 引数でtopicの配列が渡ってくる
function index($topics, $topics_num = "", $max_page = "", $page = "", $range = "")
{
    \partials\header();

    $topics = escape($topics);
?>

    <?php if ($topics) : ?>
        <article class="home" id="home">
            <div class="home-inner">
                <h2 class="home-ttl">トピック一覧</h2>
                <ul class="home-list">
                    <?php foreach ($topics as $topic) :
                        // complete_flgが１のときは完了、０のときは未完了を表示させる
                        $label = $topic->complete_flg ? '完了' : '未完了';

                        // ラベルのデザインを切り替える
                        $label_color = $topic->complete_flg ? 'complete' : 'incomplete';
                    ?>
                        <li class="home-item">
                            <a href="<?php the_url(sprintf('detail?id=%s', $topic->id)); ?>">
                                <span class="home-item-label <?php echo $label_color; ?>"><?php echo $label; ?></span>
                                <p class="home-item-ttl"><?php echo $topic->title; ?></p>
                                <p class="home-item-body"><?php echo $topic->body; ?></p>
                                <p class="home-item-position"><?php echo $topic->position; ?></p>
                                <time datetime=""><?php echo $topic->created_at; ?></time>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </article>

        <div class="pagination">
            <div class="inner">
                <p class="pagination-txt">全件数：<?php echo $topics_num; ?>件</p>

                <?php // 現在のページが２以上のときだけ「戻る」にリンクを付ける
                ?>
                <?php if ($page >= 2) : ?>
                    <a href="<?php the_url(sprintf('home?page=%d', ($page - 1))); ?>" class="page_feed">&laquo;</a>
                <?php else : ?>
                    <span class="first_last_page">&laquo;</span>
                <?php endif; ?>

                <?php // １〜最大ページまでループさせる。$rangeで表示範囲を５件に絞る
                ?>
                <?php for ($i = 1; $i <= $max_page; $i++) : ?>
                    <?php if ($i >= $page - $range && $i <= $page + $range) : ?>
                        <?php if ($i == $page) : ?>
                            <span class="now_page_number"><?php echo $i; ?></span>
                        <?php else : ?>
                            <a href="<?php the_url(sprintf('home?page=%d', $i)); ?>" class="page_number"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php // 現在ページが最大ページ数を超えたら「進む」にリンクを付けない
                ?>
                <?php if ($page < $max_page) : ?>
                    <a href="<?php the_url(sprintf('home?page=%d', $page + 1)); ?>" class="page_feed">&raquo;</a>
                <?php else : ?>
                    <span class="first_last_page">&raquo;</span>
                <?php endif; ?>
            </div>
        </div>

    <?php else : ?>

        <section class="home">
            <div class="inner">
                <p class="home-txt">トピックが登録されていません。</p>
            </div>
        </section>

    <?php endif; ?>

<?php
    \partials\footer();
}
