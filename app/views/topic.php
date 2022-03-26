<?php

namespace view\topic;

function index($topic, $type)
{
    \partials\header();

    // トピック作成、編集を兼ねているファイル
    // トピック作成か、トピック編集かによって表示内容を変える

    $disabled = '';

    if ($type === 'create') {
        $header_ttl = 'トピック作成';
        $submit_btn = '登録';
    } elseif ($type === 'edit') {
        $header_ttl = 'トピック編集';
        $submit_btn = '更新';
    } else {
        $header_ttl = 'トピック削除確認';
        $submit_btn = '削除';
        $disabled = 'disabled';
    }

?>

    <section class="topic">
        <div class="inner">
            <form class="topic-form validate-form" action="" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo $topic->id; ?>">

                <h2 class="topic-ttl"><?php echo $header_ttl; ?></h2>

                <?php if ($type === 'delete') : ?>
                    <p class="topic-txt"><span class="marker">本当に削除してもよろしいですか？</span></p>
                <?php endif; ?>

                <dl class="topic-list">
                    <dt class="topic-dttl"><label for="title" onclick="">タイトル</label></dt>
                    <dd class="topic-item">
                        <input type="text" id="title" name="title" value="<?php echo $topic->title; ?>" class="topic-input validate-target" maxlength="100" autofocus required <?php echo $disabled; ?>>
                        <p class="invalid-feedback"></p>
                    </dd>

                    <dt class="topic-dttl"><label for="body" onclick="">本文</label></dt>
                    <dd class="topic-item">
                        <textarea id="body" name="body" class="topic-textarea validate-target" autofocus required <?php echo $disabled; ?>><?php echo $topic->body; ?></textarea>
                        <p class="invalid-feedback"></p>
                    </dd>

                    <dt class="topic-dttl"><label for="position" onclick="">ポジション</label></dt>
                    <dd class="topic-item">
                        <textarea id="position" name="position" class="topic-textarea validate-target" autofocus required <?php echo $disabled; ?>><?php echo $topic->position; ?></textarea>
                        <p class="invalid-feedback"></p>
                    </dd>

                    <?php if ($type === 'edit') : ?>
                        <dt class="topic-dttl">ステータス</dt>
                        <?php //selectedがついているものが、初期表示時に表示されるステータス
                        // publishedがtrueかfalseかによって初期表示を分ける
                        ?>
                        <dd class="topic-item">
                            <input class="topic-check" type="radio" id="complete" name="complete_flg" value="1" required <?php echo $topic->complete_flg ? 'checked' : ''; ?>>
                            <label for="complete" class="topic-label">完了</label>
                        </dd>
                        <dd class="topic-item">
                            <input class="topic-check" type="radio" id="incomplete" name="complete_flg" value="0" required <?php echo $topic->complete_flg ? '' : 'checked'; ?>>
                            <label for="incomplete" class="topic-label">未完了</label>
                        </dd>
                    <?php endif; ?>
                </dl>

                <button type="submit" class="register-btn"><?php echo $submit_btn; ?></button>

                <?php // トピック作成の場合はホームへ戻る、トピック編集の場合は詳細画面に戻る
                ?>
                    <?php if ($type === 'create') : ?>
                        <a class="back-btn _home" href="<?php the_url('/'); ?>">ホームへ戻る</a>
                    <?php else : ?>
                        <a class="back-btn _back" href="<?php the_url(sprintf('detail?id=%d', $topic->id)); ?>">戻る</a>
                    <?php endif; ?>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
