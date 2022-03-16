<?php

namespace view\topic_edit;

function index($topic, $is_edit)
{
    \partials\header();

    $header_title = $is_edit ? 'トピック編集' : 'トピック作成';
?>

    <section class="edit">
        <div class="inner">
            <form class="edit-form" action="" method="POST" novalidate>
                <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">

                <h2 class="edit-ttl"><?php echo $header_title; ?></h2>

                <dl class="edit-list">
                    <dt class="edit-dttl"><label for="title" onclick="">タイトル</label></dt>
                    <dd class="edit-item">
                        <input type="text" id="title" name="title" value="<?php echo $topic->title; ?>" class="edit-text form-control validate-target" maxlength="30" autofocus required>
                        <p class="invalid-feedback"></p>
                    </dd>

                    <dt class="edit-dttl"><label for="body" onclick="">本文</label></dt>
                    <dd class="edit-item">
                        <input type="text" id="body" name="body" value="<?php echo $topic->body; ?>" class="edit-text form-control validate-target" autofocus required>
                    </dd>

                    <dt class="edit-dttl"><label for="position" onclick="">ポジション</label></dt>
                    <dd class="edit-item">
                        <input type="text" id="position" name="position" value="<?php echo $topic->position; ?>" class="edit-text form-control validate-target" autofocus required>
                    </dd>

                    <dt class="edit-dttl"><label for="status">ステータス</label></dt>
                    <dd class="edit-item">
                        <select name="status" id="status" class="form-control">
                            <?php //selectedがついているものが、初期表示時に表示されるステータス
                            // publishedがtrueかfalseかによって初期表示を分ける
                            ?>
                            <option value="1" <?php echo $topic->finish_flg ? 'selected' : ''; ?>>完了</option>
                            <option value="0" <?php echo $topic->finish_flg ? '' : 'selected'; ?>>未完了</option>
                        </select>
                    </dd>
                </dl>

                <button type="submit" class="submit-btn">更新</button>
                <span class="auth-txt"><a href="<?php the_url(GO_HOME); ?>">ホームへ戻る</a></span>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
