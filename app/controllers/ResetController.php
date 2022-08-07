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
    public function __construct()
    {
        Auth::requireLogin();
    }


    public function showRequestForm()
    {

        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

        \view\request_form\index();
    }


    public function request()
    {
        $csrf_token = get_param('_csrf_token', '');

        if (empty($csrf_token) || empty($_SESSION['_csrf_token']) || $csrf_token !== $_SESSION['_csrf_token']) {
            Msg::push(Msg::ERROR, '不正なリクエストです。');
            redirect(GO_REFERER);
        }

        $email = get_param('email', '');
        // ここでバリデーションを入れる

        $exist_user = UserQuery::fetchByEmail($email);

        // 入力されたメールアドレスが登録されたユーザーがいなければ、送信完了画面を表示
        if (!$exist_user) {
            redirect('email_sent');
            return;
        }

        // 既にパスワードリセットのフロー中がどうかを確認
        $passwordResetUser = PasswordResetQuery::fetchByEmail($email);

        $passwordResetToken = bin2hex(random_bytes(32));
        $token_sent_at = (new \DateTime())->format('Y-m-d H:i:s');


        try {

            $db = new DataSource;
            $db->begin();

            if (!$passwordResetUser) {
                // 新規リクエストであれば、登録
                PasswordResetQuery::insert($email, $passwordResetToken, $token_sent_at);
            } else {
                // 既にフロー中であれば、tokenの再発行と有効期限のリセットを行う
                PasswordResetQuery::update($email, $passwordResetToken, $token_sent_at);
            }

            if (!static::sendMail($email, $passwordResetToken)) {
                throw new Exception('メール送信に失敗しました。');
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
            Msg::push(Msg::ERROR, $e->getMessage());
            redirect(GO_REFERER);
            return;
        }

        redirect('email_sent');
    }



    public function sendMail($email, $passwordResetToken)
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











    public function login()
    {
        // 値の取得
        $name = get_param('name', '');
        $password = get_param('password', '');

        // バリデーション
        $validation = new UserValidation($name, $password);

        if (
            !($validation->validateName()
                * $validation->validatePassword())
        ) {
            redirect(GO_REFERER);
        }

        $valid_name = $validation->getValidName();
        $valid_password = $validation->getValidPassword();

        // POSTで渡ってきたユーザーネームとパスワードでログインに成功した場合、
        if (Auth::login($valid_name, $valid_password)) {
            // 登録されたユーザーオブジェクトの情報を取ってくる
            $user = UserModel::getSession();
            // オブジェクトに格納されている情報を使って、セッションのINFOにメッセージを入れる
            Msg::push(Msg::INFO, "{$user->name}さん、ようこそ。");
            // パスが空だったらトップページに移動
            redirect(GO_HOME);
        } else {
            // Auth::loginによって何がエラーかというのはpushされるので、ここでエラーメッセージは出さなくてよい

            // refererは一つ前のリクエストのパスを表す
            // 認証が失敗したときは、一つ前のリクエスト（GETメソッドでのログインページへのパス）に戻る
            redirect(GO_REFERER);
        }
    }


    public function logout()
    {
        if (Auth::logout()) {
            Msg::push(Msg::INFO, 'ログアウトしました。');
            redirect('login');
        } else {
            Msg::push(Msg::ERROR, 'ログアウトに失敗しました。');
        }
    }


    public function showRegisterForm()
    {
        if (Auth::isLogin()) {
            redirect(GO_HOME);
        }

        // 登録画面を表示
        \view\auth\index(false);
    }


    public function register()
    {
        // 値の取得
        $name = get_param('name', '');
        $password = get_param('password', '');
        $email = get_param('email', '');

        // バリデーション
        $validation = new UserValidation($name, $password, $email);

        if (
            !($validation->validateName()
                * $validation->validatePassword()
                * $validation->validateEmail())
        ) {
            redirect(GO_REFERER);
        }

        $valid_name = $validation->getValidName();
        $valid_password = $validation->getValidPassword();
        $valid_email = $validation->getValidEmail();

        // 登録処理
        if (Auth::regist($valid_name, $valid_password, $valid_email)) {
            Msg::push(Msg::INFO, "{$name}さん、ようこそ。");
            redirect(GO_HOME);
        } else {
            redirect(GO_REFERER);
        }
    }
}
