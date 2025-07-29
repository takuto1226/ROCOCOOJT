# PHP 8.2 をベースにした公式 FPM イメージを使用
FROM php:8.2-fpm
 
# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql mbstring zip
 
# Composer をグローバルにインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
 
# 作業ディレクトリを /app に設定
WORKDIR /app
 
# Laravelプロジェクトをコピー
COPY . /app
 
 
# Laravel 開発サーバが使うポート（変更可）
EXPOSE 8010