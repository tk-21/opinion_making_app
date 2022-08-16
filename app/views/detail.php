<?php

namespace view\detail;

function index($topic, $objections, $counterObjections, $opinion)
{
    \partials\header(false);

    $topic = escape($topic);
    $objections = escape($objections);
    $counterObjections = escape($counterObjections);
    $opinion = escape($opinion);

    $complete_flg = $topic->complete_flg ? '完了' : '未完了';
    $category_name = $topic->name ? $topic->name : '分類なし';
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
                        <dt class="detail-topic-ttl">カテゴリー</dt>
                        <dd class="detail-topic-data"><?php echo $category_name; ?></dd>
                    </dl>

                    <a class="edit-btn" href="<?php the_url(sprintf('topic_edit?id=%s', $topic->id)); ?>">編集</a>
                    <a class="delete-btn" href="<?php the_url(sprintf('topic_delete?id=%s', $topic->id)); ?>">削除</a>
                </li>

                <li class="detail-item">
                    <div class="objection">
                        <p class="objection-ttl">意見に対する反論</p>

                        <form class="objection-form validate-form" action="" method="post">
                            <input type="hidden" id="topic_id" name="topic_id" value="<?php echo $topic->id; ?>">
                            <input type="hidden" id="form_type" name="form_type" value="create_objection">
                            <textarea id="objection" class="objection-textarea input validate-target" name="body" required></textarea>
                            <button type="submit" id="objection-register" class="register-btn">登録</button>
                        </form>

                        <form action="" method="post">
                            <input type="hidden" name="form_type" value="delete_objection">
                            <ul class="objection-list">
                                <?php foreach ($objections as $objection) : ?>
                                    <li class="objection-item">
                                        <label>
                                            <input type="checkbox" class="objection-delete" name="delete_id[]" value="<?php echo $objection->id; ?>">
                                            <p class="objection-txt"><?php echo $objection->body; ?></p>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if (!empty($objections)) : ?>
                                <button type="submit" class="delete-btn">チェックした項目を削除</button>
                            <?php endif; ?>
                        </form>

                    </div>
                </li>

                <li class="detail-item">
                    <div class="objection">
                        <p class="objection-ttl">反論への反論</p>

                        <form class="objection-form validate-form" action="" method="post">
                            <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
                            <input type="hidden" name="form_type" value="create_counterObjection">
                            <textarea class="objection-textarea input validate-target" name="body" required></textarea>
                            <button type="submit" class="register-btn">登録</button>
                        </form>

                        <form action="" method="post">
                            <input type="hidden" name="form_type" value="delete_counterObjection">
                            <ul class="objection-list">
                                <?php foreach ($counterObjections as $counterObjection) : ?>
                                    <li class="objection-item">
                                        <label>
                                            <input type="checkbox" class="objection-delete" name="delete_id[]" value="<?php echo $counterObjection->id; ?>">
                                            <p class="objection-txt"><?php echo $counterObjection->body; ?></p>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if (!empty($counterObjections)) : ?>
                                <button type="submit" class="delete-btn">チェックした項目を削除</button>
                            <?php endif; ?>
                        </form>

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
