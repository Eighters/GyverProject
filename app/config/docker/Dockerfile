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

# BlackFire Probe
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini

# Add user devops & give sudo privilege
RUN adduser --disabled-password --gecos '' devops
RUN adduser devops sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# Override default bash config
ADD .bashrc /home/devops/.bashrc

# Add Provisionning Scripts
ADD entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
