<?php

namespace view\topic_create;

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

    <section class="create">
        <div class="inner">
            <form class="create-form" action="" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo $topic->id; ?>">

                <h2 class="create-ttl"><?php echo $header_ttl; ?></h2>

                <?php if ($type === 'delete') : ?>
                    <p class="create-txt">本当に削除してもよろしいですか？</p>
                <?php endif; ?>

                <dl class="create-list">
                    <dt class="create-dttl"><label for="title" onclick="">タイトル</label></dt>
                    <dd class="create-item">
                        <input type="text" id="title" name="title" value="<?php echo $topic->title; ?>" class="create-txt form-control validate-target" maxlength="30" autofocus required <?php echo $disabled; ?>>
                        <p class="invalid-feedback"></p>
                    </dd>

                    <dt class="create-dttl"><label for="body" onclick="">本文</label></dt>
                    <dd class="create-item">
                        <input type="text" id="body" name="body" value="<?php echo $topic->body; ?>" class="create-txt form-control validate-target" autofocus required <?php echo $disabled; ?>>
                    </dd>

                    <dt class="create-dttl"><label for="position" onclick="">ポジション</label></dt>
                    <dd class="create-item">
                        <input type="text" id="position" name="position" value="<?php echo $topic->position; ?>" class="create-txt form-control validate-target" autofocus required <?php echo $disabled; ?>>
                    </dd>

                    <?php if ($type === 'edit') : ?>
                        <dt class="create-dttl"><label for="finish_flg">ステータス</label></dt>
                        <dd class="create-item">
                            <select name="finish_flg" id="finish_flg" class="form-control">
                                <?php //selectedがついているものが、初期表示時に表示されるステータス
                                // publishedがtrueかfalseかによって初期表示を分ける
                                ?>
                                <option value="1" <?php echo $topic->finish_flg ? 'selected' : ''; ?>>完了</option>
                                <option value="0" <?php echo $topic->finish_flg ? '' : 'selected'; ?>>未完了</option>
                            </select>
                        </dd>
                    <?php endif; ?>
                </dl>

                <button type="submit" class="submit-btn"><?php echo $submit_btn; ?></button>

                <?php // トピック作成の場合はホームへ戻る、トピック編集の場合は詳細画面に戻る
                ?>
                <p class="auth-txt">
                    <?php if ($type === 'create') : ?>
                        <a href="<?php the_url('/'); ?>">ホームへ戻る</a>
                    <?php else : ?>
                        <a href="<?php the_url(sprintf('detail?id=%d', $topic->id)); ?>">戻る</a>
                    <?php endif; ?>
                </p>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
