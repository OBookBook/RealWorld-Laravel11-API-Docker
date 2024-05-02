# PHPとApacheを含むベースイメージを使用
FROM php:8.3-apache

# Composerのインストール
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

RUN composer self-update --2

# Apacheの設定ファイルをコピー
RUN cd /etc/apache2/mods-enabled \
    && ln -s ../mods-available/rewrite.load

# 設定ファイルをdockerコンテナ内のPHP、Apacheに読み込ませる
ADD php.ini /usr/local/etc/php/
ADD 000-default.conf /etc/apache2/sites-enabled/
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# ミドルウェアインストール
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    vim \
    libpng-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

RUN docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include \
    && docker-php-ext-install -j$(nproc) gd

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# Apacheの再起動
RUN service apache2 restart

# ファイルの権限を設定
RUN chmod -R 777 /var/www/html/
RUN chmod -R gu+w /var/www/html/

# 作業ディレクトリを設定
WORKDIR /var/www/html

# mod_rewriteを有効にする（Laravelのルーティングに必要）
RUN echo "Listen 8080" >> /etc/apache2/ports.conf

RUN a2enmod rewrite