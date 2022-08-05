<?php

namespace view\request_form;

function index()
{
    \partials\header(false);
?>

    <section class="auth">
        <div class="auth-inner">
            <form class="auth-form validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate>
                <h2 class="auth-ttl">パスワードリセット</h2>
                <dl class="auth-list">

                    <dt class="auth-dttl"><label for="email" onclick="">メールアドレスを入力してください。</label></dt>
                    <dd class="auth-item">
                        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
                        <input id="email" type="email" name="email" class="auth-input validate-target" autofocus required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                        <p class="invalid-feedback" id="mail-feedback"></p>
                    </dd>

                </dl>
                <button type="submit" class="register-btn auth-btn">登録</button>
            </form>


        </div>
    </section>

<?php
    \partials\footer();
}
?>
