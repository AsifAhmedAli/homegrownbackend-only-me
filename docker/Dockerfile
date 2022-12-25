FROM ubuntu:20.04

WORKDIR /var/www

RUN apt-get update

RUN apt-get -y install software-properties-common

# RUN apt-get install -y nginx php7.4-fpm supervisor

RUN apt-get update

RUN apt-get install -y \
    nginx \
    php7.4-fpm \
    supervisor \
    php7.4-json \
    php7.4-curl \
    php7.4-xml \
    php7.4-bcmath \
    php7.4-xdebug \
    php7.4-pdo \
    php7.4-pdo-mysql \
    php7.4-common \
    php7.4-mysql \
    php7.4-xml \
    php7.4-xmlrpc \
    php7.4-curl \
    php7.4-gd \
    php7.4-imagick \
    php7.4-cli \
    php7.4-dev \
    php7.4-imap \
    php7.4-mbstring \
    php7.4-opcache \
    php7.4-soap \
    php7.4-zip \
    php7.4-intl \
    php7.4-cli \
    mysql-client

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
 
COPY composer*.json ./

COPY composer*.lock ./

# COPY nginx-site.conf /etc/nginx/sites-available/default

COPY ./.docker/entrypoint.sh /etc/entrypoint.sh

RUN chmod +x /etc/entrypoint.sh

# RUN chown -R www-data:www-data /var/www 
# RUN chmod -R 775 /var/www

EXPOSE 80 443

ENTRYPOINT ["sh","/etc/entrypoint.sh"]
