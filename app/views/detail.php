<?php

namespace view\detail;

// トピックとコメントが渡ってくる
function index($topic, $objections, $counterObjections, $opinion)
{
    \partials\header();

    $topic = escape($topic);
    $objections = escape($objections);
    $counterObjections = escape($counterObjections);
    $opinion = escape($opinion);

    $opinion_btn = $opinion ? '編集' : '登録';

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
                        <a class="submit-btn" href="<?php the_url(sprintf('topic_edit?id=%s', $topic->id)); ?>">編集</a>
                    </dl>
                </li>

                <li class="detail-item">
                    <div class="detail-objection">
                        <form class="detail-form" action="" method="post">
                            <textarea name="body" id="body" rows="5" maxlength="100"></textarea>
                            <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                            <input type="hidden" name="form_type" value="<?php echo OBJECTION; ?>">
                            <button type="submit" class="submit-btn">登録</button>
                        </form>
                        <ul class="detail-objection-list">
                            <?php foreach ($objections as $objection) : ?>
                                <li class="detail-objection-item">
                                    <?php echo $objection->body; ?>
                                    <a class="delete-btn" href="<?php the_url(sprintf('delete?id=%s', $objection->id)); ?>">削除</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>

                <li class="detail-item">
                    <div class="detail-counterObjection">
                        <form class="detail-form" action="" method="post">
                            <textarea name="body" id="body" rows="5" maxlength="100"></textarea>
                            <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                            <input type="hidden" name="form_type" value="<?php echo COUNTER_OBJECTION; ?>">
                            <button type="submit" class="submit-btn">登録</button>
                        </form>
                        <ul class="detail-counterObjection-list">
                            <?php foreach ($counterObjections as $counterObjection) : ?>
                                <li class="detail-counterObjection-item">
                                    <?php echo $counterObjection->body; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <div class="detail-inner">
            <dl class="detail-opinion">
                <dt class="detail-opinion-ttl">最終的な意見</dt>
                <dd class="detail-opinion-data"><?php echo $opinion->opinion; ?></dd>
                <dt class="detail-opinion-ttl">その理由</dt>
                <dd class="detail-opinion-data"><?php echo $opinion->reason; ?></dd>
            </dl>
            <p class="opinion-txt">
                <a href="<?php the_url(sprintf('opinion_edit?id=%d', $topic->id)); ?>">
                    <?php echo $opinion_btn; ?>
                </a>
            </p>

            <a class="send-btn" href="<?php the_url('/'); ?>">トピック一覧に戻る</a>
        </div>

    </section>


<?php
    \partials\footer();
}
