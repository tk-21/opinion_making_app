<?php
// 現在のURI（ドメイン以下のパス）を取得
define('CURRENT_URI', $_SERVER['REQUEST_URI']);

// このファイルがあるディレクトリのフルパスを返す（/var/www/html/app/）
define('SOURCE_BASE', __DIR__ . '/');

define('GO_HOME', 'home');
define('GO_REFERER', 'referer');

// メッセージを開発環境では出して、本番環境では出さない
// 開発環境はtrue,本番環境はfalseとすることで、開発のときのみ表示したいメッセージを制御することができる
define('DEBUG', false);
