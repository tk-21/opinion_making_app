<?php

namespace view\topic_delete;

function index($topic, $categories)
{
    \partials\header(false);

?>

    <section class="topic">
        <div class="inner">
            <h2 class="topic-ttl">削除確認</h2>

            <dl class="topic-list">
                <dt class="topic-dttl">タイトル</dt>
                <dd class="topic-item">
                    <?php echo $topic->title; ?>
                </dd>

                <dt class="topic-dttl">本文</dt>
                <dd class="topic-item">
                    <?php echo $topic->body; ?>
                </dd>

                <dt class="topic-dttl">ポジション</dt>
                <dd class="topic-item">
                    <?php echo $topic->position; ?>
                </dd>

                <?php if ($categories) : ?>
                    <dt class="topic-dttl">カテゴリー</dt>
                    <dd class="topic-item">
                        <ul class="category-list">
                            <?php foreach ($categories as $category) : ?>
                                <li class="category-item">
                                    <label>
                                        <span class="category-txt"><?php echo $category->name; ?></span>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </dd>
                <?php endif; ?>

            </dl>

            <button type="submit" class="register-btn"><?php echo $submit_btn; ?></button>

            <a class="back-btn _back" href="<?php the_url(sprintf('detail?id=%d', $topic->id)); ?>">戻る</a>

        </div>
    </section>

<?php
    \partials\footer();
}
?>
