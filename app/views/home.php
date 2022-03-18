<?php

namespace view\home;

// 引数でtopicの配列が渡ってくる
function index($topics)
{
    \partials\header();

    $topics = escape($topics);
?>
    <article class="topic" id="topic">
        <div class="topic-inner">
            <h2 class="topic-ttl">トピック一覧</h2>
            <ul class="topic-list">
                <?php foreach ($topics as $topic) :
                    // finish_flgが１のときは完了、０のときは未完了を表示させる
                    $label = $topic->finish_flg ? '完了' : '未完了';

                    // ラベルのデザインを切り替える
                    $label_color = $topic->finish_flg ? 'completed' : 'incomplete';
                ?>
                    <li class="topic-item">
                        <a href="<?php the_url(sprintf('detail?id=%s', $topic->id)); ?>">
                            <span class="topic-item-label <?php echo $label_color; ?>"><?php echo $label; ?></span>
                            <p class="topic-item-ttl"><?php echo $topic->title; ?></p>
                            <p class="topic-item-body"><?php echo $topic->body; ?></p>
                            <p class="topic-item-position"><?php echo $topic->position; ?></p>
                            <time datetime=""><?php echo $topic->created_at; ?></time>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </article>

<?php
    \partials\footer();
}
