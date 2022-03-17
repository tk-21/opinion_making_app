<?php

namespace view\topic_create;

function index($topic, $is_create)
{
    \partials\header();

    $header_title = $is_create ? 'トピック作成' : 'トピック編集';
    $submit_btn = $is_create ? '登録' : '更新';
?>

    <section class="create">
        <div class="inner">
            <form class="create-form" action="" method="POST" novalidate>
                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">

                <h2 class="create-ttl"><?php echo $header_title; ?></h2>

                <dl class="create-list">
                    <dt class="create-dttl"><label for="title" onclick="">タイトル</label></dt>
                    <dd class="create-item">
                        <input type="text" id="title" name="title" value="<?php echo $topic->title; ?>" class="create-text form-control validate-target" maxlength="30" autofocus required>
                        <p class="invalid-feedback"></p>
                    </dd>

                    <dt class="create-dttl"><label for="body" onclick="">本文</label></dt>
                    <dd class="create-item">
                        <input type="text" id="body" name="body" value="<?php echo $topic->body; ?>" class="create-text form-control validate-target" autofocus required>
                    </dd>

                    <dt class="create-dttl"><label for="position" onclick="">ポジション</label></dt>
                    <dd class="create-item">
                        <input type="text" id="position" name="position" value="<?php echo $topic->position; ?>" class="create-text form-control validate-target" autofocus required>
                    </dd>

                    <?php if (!$is_create) : ?>
                        <dt class="create-dttl"><label for="status">ステータス</label></dt>
                        <dd class="create-item">
                            <select name="status" id="status" class="form-control">
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
                <span class="auth-txt"><a href="<?php the_url(GO_HOME); ?>">ホームへ戻る</a></span>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
