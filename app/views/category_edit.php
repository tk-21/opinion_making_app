<?php

namespace view\category_edit;

function index($topic)
{
    \partials\header(false);

    $topic = escape($topic);


?>

    <section class="topic">
        <div class="inner">
            <form class="topic-form validate-form" action="" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo $topic->id; ?>">

                <h2 class="topic-ttl"><?php echo $header_ttl; ?></h2>

                <dl class="topic-list">

                    <dt class="topic-dttl"><label for="body" onclick="">本文</label></dt>
                    <dd class="topic-item">
                        <textarea id="body" name="body" class="topic-textarea input validate-target" autofocus required><?php echo $topic->body; ?></textarea>
                        <p class="invalid-feedback"></p>
                    </dd>

                </dl>

                <button type="submit" class="register-btn"><?php echo $submit_btn; ?></button>

                <a class="back-btn _back" href="<?php the_url(sprintf('detail?id=%d', $topic->id)); ?>">戻る</a>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
