<?php

namespace view\home;

use DateTime;

// 引数でtopicの配列が渡ってくる
function index($topic_num = "", $max_page = "", $current_page = "", $range = "", $topics, $categories, $is_home)
{
    \partials\header();

    $topics = escape($topics);

    $path = $is_home ? 'home' : 'category';
?>

    <?php if ($topics) : ?>
        <article class="home" id="home">
            <div class="home-inner">
                <h2 class="home-ttl">トピック一覧</h2>
                <ul class="home-list">
                    <li class="home-item">
                        <ul class="home-topic-list">
                            <?php foreach ($topics as $topic) :
                                // complete_flgが１のときは完了、０のときは未完了を表示させる
                                $label = $topic->complete_flg ? '完了' : '未完了';

                                // ラベルのデザインを切り替える
                                $label_style = $topic->complete_flg ? 'complete' : 'incomplete';

                                // 日時表示をフォーマットするためオブジェクトを作成
                                $created_at = new DateTime($topic->created_at);
                            ?>
                                <li class="home-topic-item">
                                    <a href="<?php the_url(sprintf('detail?id=%s', $topic->id)); ?>">
                                        <p class="home-topic-label home-topic-<?php echo $label_style; ?>"><?php echo $label; ?></p>
                                        <div class="home-topic-body">
                                            <time datetime="<?php echo $topic->created_at; ?>"><?php echo $created_at->format('Y.m.d'); ?></time>
                                            <p class="home-topic-ttl"><?php echo $topic->title; ?></p>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </li>

                    <li class="home-item">
                        <p class="home-category-ttl">カテゴリーの作成</p>

                        <form class="home-category-form validate-form" action="" method="post">
                            <textarea class="home-category-textarea input validate-target" name="name" required></textarea>
                            <button type="submit" class="register-btn">登録</button>
                        </form>

                        <ul class="home-category-list">
                            <?php foreach ($categories as $category) : ?>
                                <li class="home-category-item">
                                    <a href="<?php the_url(sprintf('category?id=%s', $category->id)); ?>">
                                        <?php echo $category->name; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>


                <p class="home-txt">全件数：<?php echo $topic_num; ?>件</p>

                <?php $category_id = get_param('id', null, false) ?>

                <ul class="pagination">
                    <?php // 現在のページが２以上のときだけ「戻る」にリンクを付ける
                    ?>
                    <li class="pagination-item">
                        <?php if ($current_page >= 2) : ?>
                            <a href="<?php the_url(sprintf('%s?id=%s&page=%d', $path, $category_id, ($current_page - 1))); ?>">&laquo;</a>
                        <?php else : ?>
                            <span class="pagination-pre">&laquo;</span>
                        <?php endif; ?>
                    </li>

                    <?php // １〜最大ページまでループさせ、$rangeで表示範囲を５件に絞る。現在のページ番号にはリンクを付けない。
                    ?>
                    <?php for ($i = 1; $i <= $max_page; $i++) : ?>
                        <?php if ($i >= $current_page - $range && $i <= $current_page + $range) : ?>
                            <li class="pagination-item">
                                <?php if ($i == $current_page) : ?>
                                    <span class="pagination-now"><?php echo $i; ?></span>
                                <?php else : ?>
                                    <a href="<?php the_url(sprintf('%s?id=%s&page=%d', $path, $category_id, $i)); ?>" class="pagination-num"><?php echo $i; ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php // 現在ページが最大ページ数を超えたら「進む」にリンクを付けない
                    ?>
                    <li class="pagination-item">
                        <?php if ($current_page < $max_page) : ?>
                            <a href="<?php the_url(sprintf('%s?id=%s&page=%d', $path, $category_id, ($current_page + 1))); ?>">&raquo;</a>
                        <?php else : ?>
                            <span class="pagination-next">&raquo;</span>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </article>


    <?php else : ?>

        <section class="home">
            <div class="home-inner">
                <p class="home-txt _no">トピックがありません。</p>
                <a class="back-btn _home" href="<?php the_url('/'); ?>">ホームへ戻る</a>
            </div>
        </section>

    <?php endif; ?>

<?php
    \partials\footer();
}
