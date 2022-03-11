<?php

namespace view\detail;

// トピックとコメントが渡ってくる
function index($topic, $comments)
{
    \partials\header();

    $topic = escape($topic);
    $comments = escape($comments);

    // 以下でトピックに紐付くコメントを表示する
?>

    <section class="detail">
        <div class="inner">
            <dl class="detail-list">
                <dt class="detail-tit">タイトル</dt>
                <dd class="detail-data"><?php echo $topic->title; ?></dd>
                <dt class="detail-tit">内容</dt>
                <dd class="detail-data"><?php echo $topic->body; ?></dd>
                <dt class="detail-tit">ポジション</dt>
                <dd class="detail-data"><?php echo $topic->position; ?></dd>
            </dl>

        </div>
    </section>



    <ul class="list-unstyled">
        <?php foreach ($comments as $comment) : ?>
            <?php
            // agreeが１のときは賛成、０のときは反対を返す
            $agree_label = $comment->agree ? '賛成' : '反対';
            // 賛成か反対かによって色を変える
            $agree_cls = $comment->agree ? 'badge-success' : 'badge-danger';
            ?>

            <li class="bg-white shadow-sm mb-3 rounded p-3">
                <h2 class="h4 mb-2">
                    <span class="badge mr-1 align-bottom <?php echo $agree_cls; ?>"><?php echo $agree_label; ?></span>
                    <span><?php echo $comment->body; ?></span>
                </h2>
                <span>Commented by <?php echo $comment->nickname; ?></span>
            </li>
        <?php endforeach; ?>
    </ul>

<?php
    \partials\footer();
}
