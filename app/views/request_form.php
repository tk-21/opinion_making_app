<?php

namespace view\request_form;

function index()
{
    \partials\header(false);

    $csrf_token = bin2hex(random_bytes(32));
?>

    <section class="auth">
        <div class="auth-inner">
            <form class="auth-form validate-form" action="" method="POST" novalidate>
                <input type="hidden" name="csrf_token" value="<? echo $csrf_token; ?>">

                <h2 class="auth-ttl">パスワードリセット</h2>
                <dl class="auth-list">

                    <dt class="auth-dttl"><label for="email" onclick="">メールアドレスを入力してください。</label></dt>
                    <dd class="auth-item">
                        <input id="email" type="email" name="email" class="auth-input validate-target" autofocus required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                        <p class="invalid-feedback" id="mail-feedback"></p>
                    </dd>

                </dl>
                <button type="submit" class="register-btn auth-btn">送信</button>
            </form>


        </div>
    </section>

<?php
    \partials\footer();
}
?>
