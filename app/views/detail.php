<?php

namespace view\detail;

function index($topic, $objections, $counterObjections, $opinion)
{
    \partials\header();

    $topic = escape($topic);
    $objections = escape($objections);
    $counterObjections = escape($counterObjections);
    $opinion = escape($opinion);

    $complete_flg = $topic->complete_flg ? '完了' : '未完了';
    $is_edit = $opinion ? 'edit' : 'create';

?>

    <section class="detail">
        <div class="detail-inner">

            <ul class="detail-list">
                <li class="detail-item">
                    <dl class="detail-topic">
                        <dt class="detail-topic-ttl">タイトル</dt>
                        <dd class="detail-topic-data"><?php echo $topic->title; ?></dd>
                        <dt class="detail-topic-ttl">内容</dt>
                        <dd class="detail-topic-data"><?php echo $topic->body; ?></dd>
                        <dt class="detail-topic-ttl">ポジション</dt>
                        <dd class="detail-topic-data"><?php echo $topic->position; ?></dd>
                        <dt class="detail-topic-ttl">ステータス</dt>
                        <dd class="detail-topic-data"><?php echo $complete_flg; ?></dd>
                    </dl>
                    <a class="edit-btn" href="<?php the_url(sprintf('topic_edit?id=%s', $topic->id)); ?>">編集</a>
                    <a class="delete-btn" href="<?php the_url(sprintf('delete?type=%s&id=%s', TOPIC, $topic->id)); ?>">削除</a>

                </li>

                <li class="detail-item">
                    <div class="detail-objection">
                        <form class="detail-form validate-form" action="" method="post">
                            <textarea class="detail-textarea validate-target" name="body" required></textarea>
                            <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                            <input type="hidden" name="form_type" value="<?php echo OBJECTION; ?>">
                            <button type="submit" class="register-btn">登録</button>
                        </form>
                        <ul class="detail-objection-list">
                            <?php foreach ($objections as $objection) : ?>
                                <li class="detail-objection-item">
                                    <span><?php echo $objection->body; ?></span>
                                    <a class="delete-icon" href="<?php the_url(sprintf('delete?type=%s&id=%s', OBJECTION, $objection->id)); ?>"><img src="../public/img/trash.svg" alt=""></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>

                <li class="detail-item">
                    <div class="detail-counterObjection">
                        <form class="detail-form validate-form" action="" method="post">
                            <textarea class="detail-textarea validate-target" name="body" required></textarea>
                            <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                            <input type="hidden" name="form_type" value="<?php echo COUNTER_OBJECTION; ?>">
                            <button type="submit" class="register-btn">登録</button>
                        </form>
                        <ul class="detail-objection-list">
                            <?php foreach ($counterObjections as $counterObjection) : ?>
                                <li class="detail-objection-item">
                                    <?php echo $counterObjection->body; ?>
                                    <a class="delete-icon" href="<?php the_url(sprintf('delete?type=%s&id=%s', COUNTER_OBJECTION, $counterObjection->id)); ?>"><img src="../public/img/trash.svg" alt=""></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            </ul>

            <dl class="detail-opinion">
                <dt class="detail-opinion-ttl">最終的な意見：</dt>
                <dd class="detail-opinion-data"><?php echo $opinion->opinion; ?></dd>
                <dt class="detail-opinion-ttl">その理由：</dt>
                <dd class="detail-opinion-data"><?php echo $opinion->reason; ?></dd>
                <a class="edit-btn" href="<?php the_url(sprintf('opinion_%s?id=%d', $is_edit, $topic->id)); ?>">編集</a>
            </dl>

            <a class="back-btn _home" href="<?php the_url('/'); ?>">トピック一覧に戻る</a>

        </div>
    </section>


<?php
    \partials\footer();
}
