FROM php:7.3-fpm

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mysqli
RUN echo "alias ll='ls -la'" >> ~/.bashrc && . ~/.bashrc
WORKDIR /var/www/html



# xdebugをインストールして有効化
RUN pecl install xdebug && docker-php-ext-enable xdebug



# wgetをインストールするよう修正
RUN apt-get update && apt-get install -y wget

# ホスト環境で作ったphp.iniをコンテナにコピー
COPY php.ini /usr/local/etc/php/conf.d/php.ini

# mhsendmailコマンドのインストール。CURLでダウンロードしてインストールします。
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail
