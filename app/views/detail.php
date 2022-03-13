<?php

namespace view\detail;

// トピックとコメントが渡ってくる
function index($topic, $objections, $counterObjections)
{
    \partials\header();

    $topic = escape($topic);
    $objections = escape($objections);
    $counterObjections = escape($counterObjections);

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
                <form action="" method="post">
                    <textarea name="body" id="body" rows="5" maxlength="100"></textarea>
                    <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                    <input type="hidden" name="form_type" value="<?php echo OBJECTION; ?>">
                    <button type="submit" class="submit-btn">登録</button>
                </form>
                <ul class="detail-objection-list">
                    <?php foreach ($objections as $objection) : ?>
                        <li class="detail-objection-item">
                            <?php echo $objection->body; ?>
                            <button type="submit" class="delete-btn" data-id="<?php echo $objection->id ?>">
                                <a href="<?php the_url(sprintf('delete?id=%s', $objection->id)); ?>">削除</a>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="detail-counterObjection">
                <form action="" method="post">
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

        </div>
    </section>


<?php
    \partials\footer();
}
