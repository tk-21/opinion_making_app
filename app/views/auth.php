<?php

namespace view\auth;

function index($is_login)
{
    \partials\header(true);

    if ($is_login) {
        $header_ttl = 'ログイン';
        $submit_btn = 'ログイン';
        $link_btn = 'アカウント登録';
    } else {
        $header_ttl = 'アカウント登録';
        $submit_btn = '登録';
        $link_btn = 'ログイン画面へ';
    }
?>

    <section class="auth">
        <div class="auth-inner">
            <form class="auth-form validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate>
                <h2 class="auth-ttl"><?php echo $header_ttl; ?></h2>
                <dl class="auth-list">
                    <dt class="auth-dttl"><label for="name" onclick="">ユーザーネーム</label></dt>
                    <dd class="auth-item">
                        <input id="name" type="text" name="name" class="auth-input validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                        <p class="invalid-feedback"></p>
                    </dd>
                    <dt class="auth-dttl"><label for="password" onclick="">パスワード</label></dt>
                    <dd class="auth-item">
                        <input id="password" type="password" name="password" class="auth-input validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                        <p class="invalid-feedback"></p>
                    </dd>
                </dl>
                <button type="submit" class="register-btn auth-btn"><?php echo $submit_btn; ?></button>
            </form>

            <?php if ($is_login) : ?>
                <a class="back-btn _home" href="<?php the_url('register'); ?>"><?php echo $link_btn; ?></a>
            <?php else : ?>
                <a class="back-btn _home" href="<?php the_url('login'); ?>"><?php echo $link_btn; ?></a>
            <?php endif; ?>

        </div>
    </section>

<?php
    \partials\footer();
}
?>
