FROM php:7.0-fpm

RUN apt-get update \
    && apt-get install -y \
        libicu-dev \
        zlib1g-dev \
        git \
        nodejs \
        npm \
        sudo \
    && docker-php-ext-install \
        zip \
        intl \
        json \
        mbstring \
        mysqli \
        pdo_mysql \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

# opcache
RUN docker-php-ext-install opcache

# APCu
RUN pecl install apcu \
	&& echo "extension=apcu.so\napc.enable_cli = 1" > /usr/local/etc/php/conf.d/ext-apcu.ini

# NodeJs
RUN ln -s /usr/bin/nodejs /usr/bin/node

# Add user devops & give sudo privilege
RUN adduser --disabled-password --gecos '' devops
RUN adduser devops sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# Override default bash config
ADD .bashrc /home/devops/.bashrc

# Add Provisionning Scripts
ADD entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
