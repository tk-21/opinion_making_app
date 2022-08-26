<?php

namespace view\category_edit;

function index($category)
{
    \partials\header(false);

    $category = escape($category);


?>

    <section class="category">
        <div class="inner">
            <form class="category-form validate-form" action="" method="POST" novalidate>
                <input type="hidden" name="id" value="<?php echo $category->id; ?>">

                <dl class="category-list">

                    <dt class="category-dttl"><label for="name" onclick="">カテゴリー名の編集</label></dt>
                    <dd class="category-item">
                        <textarea id="name" name="name" class="category-name input validate-target" autofocus required><?php echo $category->name; ?></textarea>
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
