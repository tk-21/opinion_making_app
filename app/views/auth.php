<?php

namespace view\auth;

function index($is_login)
{
    \partials\header();

    // ログイン画面の表示かアカウント登録画面の表示かを切り替える
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

                    <?php if (!$is_login) : ?>
                        <dt class="auth-dttl"><label for="email" onclick="">メールアドレス</label></dt>
                        <dd class="auth-item">
                            <input id="email" type="email" name="email" class="auth-input validate-target" autofocus required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                            <p class="invalid-feedback" id="mail-feedback"></p>
                        </dd>
                    <?php endif; ?>

                </dl>
                <button type="submit" class="register-btn auth-btn"><?php echo $submit_btn; ?></button>
            </form>

            <?php if ($is_login) : ?>
                <a class="back-btn _home" href="<?php the_url('request'); ?>">パスワードを忘れた方はこちら</a>
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
