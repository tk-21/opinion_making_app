<?php

namespace view\opinion;

function index($opinion, $topic, $is_create)
{
    \partials\header();

    // 意見作成、編集を兼ねているファイル
    // 意見作成か、意見編集かによって表示内容を変える
    $header_ttl = $is_create ? '最終意見の言語化' : '意見の編集';
    $submit_btn = $is_create ? '登録' : '更新';
?>

    <section class="opinion">
        <div class="inner">
            <form class="opinion-form" action="" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo $opinion->id; ?>">

                <h2 class="opinion-ttl"><?php echo $header_ttl; ?></h2>

                <dl class="opinion-list">
                    <dt class="opinion-dttl"><label for="opinion" onclick="">自分の意見</label></dt>
                    <dd class="opinion-item">
                        <input type="text" id="opinion" name="opinion" value="<?php echo $opinion->opinion; ?>" class="opinion-text form-control validate-target" maxlength="30" autofocus required>
                        <p class="invalid-feedback"></p>
                    </dd>

                    <dt class="opinion-dttl"><label for="reason" onclick="">その理由</label></dt>
                    <dd class="opinion-item">
                        <input type="text" id="reason" name="reason" value="<?php echo $opinion->reason; ?>" class="opinion-text form-control validate-target" autofocus required>
                    </dd>
                </dl>

                <button type="submit" class="submit-btn"><?php echo $submit_btn; ?></button>

                <p class="opinion-txt"><a href="<?php the_url(sprintf('detail?id=%d', $topic->id)); ?>">戻る</a></p>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
