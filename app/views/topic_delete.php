<?php

namespace view\topic_delete;

function index($topic)
{
    \partials\header(false);

    $topic = escape($topic);

    $complete_flg = $topic->complete_flg ? '完了' : '未完了';
    $category_name = $topic->name ? $topic->name : '分類なし';

?>

    <section class="confirm">
        <div class="inner">
            <form class="confirm-form" action="" method="post">
                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">

                <h2 class="confirm-ttl">トピック削除確認</h2>

                <p class="confirm-txt"><span class="marker">本当に削除してもよろしいですか？</span></p>

                <dl class="confirm-list">
                    <dt class="confirm-dttl">タイトル</dt>
                    <dd class="confirm-item">
                        <?php echo $topic->title; ?>
                    </dd>

                    <dt class="confirm-dttl">本文</dt>
                    <dd class="confirm-item">
                        <?php echo $topic->body; ?>
                    </dd>

                    <dt class="confirm-dttl">ポジション</dt>
                    <dd class="confirm-item">
                        <?php echo $topic->position; ?>
                    </dd>

                    <dt class="confirm-dttl">ステータス</dt>
                    <dd class="confirm-item">
                        <?php echo $complete_flg; ?>
                    </dd>

                    <dt class="confirm-dttl">カテゴリー</dt>
                    <dd class="confirm-item">
                        <?php echo $category_name; ?>
                    </dd>
                </dl>

                <button type="submit" class="register-btn">削除</button>

                <a class="back-btn _back" href="<?php the_url(sprintf('detail?id=%d', $topic->id)); ?>">戻る</a>
            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
