<?php

namespace view\login;


// HTMLを関数で囲んでおくと、その関数を呼んだときにHTMLの内容が出力されるようになる
function index()
{
    \partials\header();
?>

    <section class="auth">
        <div class="auth-inner">
            <form class="auth-form validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate>
                <h2 class="auth-ttl">ログイン</h2>
                <dl class="auth-list">
                    <dt class="auth-dttl"><label for="name" onclick="">ユーザーネーム</label></dt>
                    <dd class="auth-item">
                        <input id="name" type="text" name="name" class="auth-input form-control validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                        <p class="invalid-feedback"></p>
                    </dd>
                    <dt class="auth-dttl"><label for="password" onclick="">パスワード</label></dt>
                    <dd class="auth-item">
                        <input id="password" type="password" name="password" class="auth-input form-control validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                        <p class="invalid-feedback"></p>
                    </dd>
                </dl>
                <button type="submit" class="submit-btn">ログイン</button>
            </form>
            <p class="auth-txt"><a href="<?php the_url('register'); ?>">アカウント登録</a></p>
        </div>
    </section>

<?php
    \partials\footer();
}
?>
