<?php

namespace view\home;

use DateTime;

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
                        $label_style = $topic->complete_flg ? 'complete' : 'incomplete';

                        // 日時表示をフォーマットするためオブジェクトを作成
                        $created_at = new DateTime($topic->created_at);
                    ?>
                        <li class="home-item">
                            <a href="<?php the_url(sprintf('detail?id=%s', $topic->id)); ?>">
                                <p class="home-item-label home-item-<?php echo $label_style; ?>"><?php echo $label; ?></p>
                                <div class="home-item-body">
                                    <time datetime="<?php echo $topic->created_at; ?>"><?php echo $created_at->format('Y.m.d'); ?></time>
                                    <p class="home-item-ttl"><?php echo $topic->title; ?></p>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>


                <p class="home-txt">全件数：<?php echo $topics_num; ?>件</p>

                <ul class="pagination">
                    <?php // 現在のページが２以上のときだけ「戻る」にリンクを付ける
                    ?>
                    <li class="pagination-item">
                        <?php if ($page >= 2) : ?>
                            <a href="<?php the_url(sprintf('home?page=%d', ($page - 1))); ?>">&laquo;</a>
                        <?php else : ?>
                            <span class="pagination-pre">&laquo;</span>
                        <?php endif; ?>
                    </li>

                    <?php // １〜最大ページまでループさせ、$rangeで表示範囲を５件に絞る。現在のページ番号にはリンクを付けない。
                    ?>
                    <?php for ($i = 1; $i <= $max_page; $i++) : ?>
                        <?php if ($i >= $page - $range && $i <= $page + $range) : ?>
                            <li class="pagination-item">
                                <?php if ($i == $page) : ?>
                                    <span class="pagination-now"><?php echo $i; ?></span>
                                <?php else : ?>
                                    <a href="<?php the_url(sprintf('home?page=%d', $i)); ?>" class="pagination-num"><?php echo $i; ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php // 現在ページが最大ページ数を超えたら「進む」にリンクを付けない
                    ?>
                    <li class="pagination-item">
                        <?php if ($page < $max_page) : ?>
                            <a href="<?php the_url(sprintf('home?page=%d', $page + 1)); ?>">&raquo;</a>
                        <?php else : ?>
                            <span class="pagination-next">&raquo;</span>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </article>


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
