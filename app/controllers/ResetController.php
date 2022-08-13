<?php

namespace controllers;

use db\DataSource;
use db\PasswordResetQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;
use db\UserQuery;
use Exception;
use validation\UserValidation;

class ResetController
{
    // インスタンス生成時にログイン確認を実行
    // public function __construct()
    // {
    //     Auth::requireLogin();
    // }


    public function showRequestForm()
    {
        \view\request_form\index();
    }



    public function request()
    {
        $csrf_token = get_param('csrf_token', '');

        if (empty($csrf_token)) {
            Msg::push(Msg::ERROR, '不正なリクエストです。');
            redirect(GO_REFERER);
        }

        $email = get_param('email', '');

        $validation = new UserValidation('', '', $email);

        if (!$validation->validateEmail()) {
            Msg::push(Msg::ERROR, 'リクエストに失敗しました。');
            redirect(GO_REFERER);
        }

        $valid_email = $validation->getValidEmail();

        // メールアドレスからユーザー情報を取得
        $exist_user = UserQuery::fetchByEmail($valid_email);

        // 入力されたメールアドレスが登録されたユーザーがいなければ、送信完了画面を表示
        if (!$exist_user) {
            redirect('email_sent');
            return;
        }

        // 既にパスワードリセットのフロー中がどうかを確認
        $passwordResetUser = PasswordResetQuery::fetchByEmail($valid_email);

        $passwordResetToken = bin2hex(random_bytes(32));
        $token_sent_at = (new \DateTime())->format('Y-m-d H:i:s');

        // DBへの登録とメール送信を行う
        try {
            $db = new DataSource;
            $db->begin();

            if (!$passwordResetUser) {
                // 値が取れてこなければ新規リクエストとみなし、登録
                PasswordResetQuery::insert($valid_email, $passwordResetToken, $token_sent_at);
            } else {
                // 既にフロー中であれば、tokenの再発行と有効期限のリセットを行う
                PasswordResetQuery::update($valid_email, $passwordResetToken, $token_sent_at);
            }

            // メールの送信
            if (!static::sendResetMail($valid_email, $passwordResetToken)) {
                throw new Exception('メール送信に失敗しました。');
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'エラーが発生しました。');
        }

        redirect('email_sent');
    }



    public function sendResetMail($email, $passwordResetToken)
    {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $url = sprintf('%s%s?token=%s', BASE_PATH, 'request', $passwordResetToken);

        $subject = 'パスワードリセット用URLをお送りします。';

        $body = <<<EOD
        24時間以内に下記URLへアクセスし、パスワードの変更を完了してください。
        {$url}
        EOD;

        $headers = "From : hoge@hoge.com";
        $headers .= "Content-Type : text/plain";

        return mb_send_mail($email, $subject, $body, $headers);
    }



    public function showEmailSent()
    {
        \view\email_sent\index();
    }



    public function showResetForm()
    {
        $passwordResetToken = get_param('token', '', false);

        // トークンに合致するユーザーを取得
        $passwordResetUser = PasswordResetQuery::fetchByToken($passwordResetToken);

        // トークンに合致するユーザーがいなければ処理を中止
        if (!$passwordResetUser) {
            Msg::push(Msg::ERROR, '無効なURLです。');
            exit;
        }

        // tokenの有効期限を24時間に設定
        $tokenValidPeriod = (new \DateTime())->modify('-24 hour')->format('Y-m-d H:i:s');

        // リクエストが24時間以上前の場合、有効期限切れとする
        if ($passwordResetUser->token_sent_at < $tokenValidPeriod) {
            Msg::push(Msg::ERROR, '有効期限切れです。');
            exit;
        }

        \view\reset_form\index($passwordResetToken);
    }



    public function reset()
    {
        $password = get_param('password', '');

        $validation = new UserValidation('', $password);

        if (!$validation->validatePassword()) {
            Msg::push(Msg::ERROR, 'パスワード変更に失敗しました。');
            redirect(GO_REFERER);
        }

        $valid_password = $validation->getValidPassword();

        $password_confirmation = get_param('password_confirmation', '');

        // 確認用パスワードとの照合
        if ($valid_password !== $password_confirmation) {
            Msg::push(Msg::ERROR, 'パスワードが確認用パスワードと一致していません。');
            redirect(GO_REFERER);
        }

        $csrf_token = get_param('csrf_token', '');

        if (empty($csrf_token)) {
            Msg::push(Msg::ERROR, '不正なリクエストです。');
            redirect(GO_REFERER);
        }

        $passwordResetToken = get_param('password_reset_token', '');

        // トークンに合致するユーザーを取得
        $passwordResetUser = PasswordResetQuery::fetchByToken($passwordResetToken);

        // トークンに合致するユーザーがいなければ処理を中止
        if (!$passwordResetUser) {
            Msg::push(Msg::ERROR, '無効なURLです。');
            exit;
        }

        // パスワードをハッシュ化
        $hashedPassword = password_hash($valid_password, PASSWORD_DEFAULT);

        try {
            $db = new DataSource;
            $db->begin();

            // ユーザーテーブルのパスワードを更新し、パスワードリセットテーブルから削除
            if (UserQuery::update($hashedPassword, $passwordResetUser) &&          PasswordResetQuery::delete($passwordResetUser)) {
                $db->commit();
                Msg::push(Msg::INFO, 'パスワードの変更が完了しました。');
            }
        } catch (Exception $e) {
            $db->rollback();

            Msg::push(Msg::DEBUG, $e->getMessage());
            Msg::push(Msg::ERROR, 'エラーが発生しました。');
        }

        // メールアドレスからユーザー情報を取得
        $user = UserQuery::fetchByEmail($passwordResetUser->email);

        // 変更完了メール送信
        static::sendCompleteMail($user->email);

        // ログインしてマイページへ遷移
        static::login($user->name, $user->password);
    }



    public function sendCompleteMail($email)
    {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $subject = 'パスワードの変更が完了しました。';

        $body = <<<EOD
        パスワードの変更が完了しました。
        EOD;

        $headers = "From : hoge@hoge.com";
        $headers .= "Content-Type : text/plain";

        return mb_send_mail($email, $subject, $body, $headers);
    }



    public function login($name, $password)
    {
        if (Auth::login($name, $password)) {
            $user = UserModel::getSession();
            Msg::push(Msg::INFO, "{$user->name}さん、ようこそ。");
            redirect(GO_HOME);
        } else {
            redirect(GO_REFERER);
        }
    }
}
