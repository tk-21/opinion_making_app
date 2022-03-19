<?php

namespace view\opinion_edit;

function index($opinion, $topic)
{
    \partials\header();
?>

    <section class="opinion">
        <div class="inner">
            <form class="opinion-form" action="" method="POST" novalidate>

                <h2 class="opinion-ttl">最終意見の言語化</h2>

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

                <button type="submit" class="submit-btn">登録</button>

                <p class="opinion-txt"><a href="<?php the_url(sprintf('detail?id=%d', $topic->id)); ?>">戻る</a></p>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
