# ベースイメージにPHPとApacheを含むものを指定
FROM php:8.2-apache

# 必要なPHP拡張モジュールをインストール
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo_mysql zip \
    && docker-php-ext-enable mysqli
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php.ini \
    && sed -i 's/;extension=mysqli/exension=mysqli/' /usr/local/etc/php/php.ini

# Composerのインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apacheのドキュメントルートを設定
WORKDIR /var/www/html

# GuzzleHTTPをインストール
RUN composer require guzzlehttp/guzzle
# Spatieをインストール
RUN composer require Spatie/PdfToText

# 権限設定
RUN chown -R www-data:www-data /var/www/html

# Apacheのポートを開放
EXPOSE 80
