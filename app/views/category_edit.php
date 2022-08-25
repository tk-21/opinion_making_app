<?php

namespace view\category_edit;

function index($category)
{
    \partials\header(false);

    $category = escape($category);


?>

    <section class="topic">
        <div class="inner">
            <form class="topic-form validate-form" action="" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo $category->id; ?>">

                <dl class="topic-list">

                    <dt class="topic-dttl"><label for="body" onclick="">カテゴリー名の編集</label></dt>
                    <dd class="topic-item">
                        <textarea id="body" name="body" class="topic-textarea input validate-target" autofocus required><?php echo $category->name; ?></textarea>
                        <p class="invalid-feedback"></p>
                    </dd>

                </dl>

                <button type="submit" class="register-btn">更新</button>

                <a class="back-btn _back" href="<?php the_url(sprintf('category?id=%d', $category->id)); ?>">戻る</a>

            </form>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
