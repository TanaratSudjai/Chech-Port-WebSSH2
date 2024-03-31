FROM php:7.4-apache

# ติดตั้ง ssh
RUN apt-get update && \
    apt-get install -y libssh2-1-dev libssh2-1

#ติดตั้ง ssh2 -> extension เเล้ว ให้ docker เปิดด้วย  docker-php-ext-enable
RUN pecl install ssh2-1.3.1 && \
    docker-php-ext-enable ssh2

# นำเข้า โมดูลของ Apache
RUN a2enmod rewrite

# Restart server apache เพื่อ ใช้ ssh2 
RUN service apache2 restart
