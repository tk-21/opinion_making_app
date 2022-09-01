<?php

namespace view\objection_edit;

function index($objection)
{
    \partials\header(false);

    $objection = escape($objection);

?>

    <section class="objection">
        <div class="inner">
            <form class="objection-form validate-form" action="" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo $objection->id; ?>">

                <dl class="objection-list">

                    <dt class="objection-dttl"><label for="body" onclick="">反論の編集</label></dt>
                    <dd class="objection-item">
                        <textarea id="body" name="body" class="objection-body input validate-target" autofocus required><?php echo $objection->body; ?></textarea>
                        <p class="invalid-feedback"></p>
                    </dd>

                </dl>

                <button type="submit" class="register-btn">更新</button>

                <a class="back-btn _back" href="<?php the_url(sprintf('detail?id=%d', $objection->topic_id)); ?>">戻る</a>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
