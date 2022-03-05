<?php

namespace view\login;

// HTMLを関数で囲んでおくと、その関数を呼んだときにHTMLの内容が出力されるようになる
function index()
{
?>

    <section class="login">
        <div class="auth-inner">
            <form class="form validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate>
                <h2 class="form-ttl">ログイン</h2>
                <dl class="form-list">
                    <dt class="form-dttl"><label for="name" onclick="">ユーザーネーム</label></dt>
                    <dd class="form-item">
                        <input type="text" name="name" class="form-text form-control validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                        <div class="invalid-feedback"></div>
                    </dd>
                </dl>
                <dl class="form-list">
                    <dt class="form-dttl"><label for="password" onclick="">パスワード</label></dt>
                    <dd class="form-item">
                        <input type="password" name="password" class="form-text form-control validate-target" autofocus required minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+">
                        <div class="invalid-feedback"></div>
                    </dd>
                </dl>
                <button type="submit" class="submit-btn">ログイン</button>
                <div>
                    <a href="<?php the_url('register'); ?>">アカウント登録</a>
                </div>
            </form>
        </div>
    </section>

<?php
}
?>
