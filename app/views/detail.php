<?php

namespace view\detail;

// トピックとコメントが渡ってくる
function index($topic, $objections)
{
    \partials\header();

    $topic = escape($topic);
    $objections = escape($objections);

    // 以下でトピックに紐付くコメントを表示する
?>

    <section class="detail">
        <div class="detail-inner">
            <dl class="detail-topic-list">
                <dt class="detail-topic-ttl">タイトル</dt>
                <dd class="detail-topic-data"><?php echo $topic->title; ?></dd>
                <dt class="detail-topic-ttl">内容</dt>
                <dd class="detail-topic-data"><?php echo $topic->body; ?></dd>
                <dt class="detail-topic-ttl">ポジション</dt>
                <dd class="detail-topic-data"><?php echo $topic->position; ?></dd>
            </dl>

            <div class="detail-objection">
                <form action="" method="post"></form>
                <ul class="detail-objection-list">
                    <?php foreach ($objections as $objection) : ?>
                        <li class="detail-objection-item">
                            <?php echo $objection->body; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </section>


<?php
    \partials\footer();
}
