# VERSION:		  1.1
# DESCRIPTION:	  Create the env for the gyver project
# AUTHOR:		  Gauvin Thibaut  <gauvin.thibaut83@gmail.com>
# COMMENTS:
#	This file describes how to build environment for the Gyver Project.
#	It is a Symfony 2.7.6 Project and we use :
#	PHP, MySql, Sass, Materialize, Nginx & NodeJs, Gulp, Bower
#	Tested on Ubuntu 14.04
#
#
# FIRST USAGE:
#	# 1). Build GyverProject image :
#	docker build -t gyver_base_image .
#
#   # 2). Run container :
#   docker run -ti -d -p 999:80 --name gyverproject -v /path/to/your/project:/home/app gyver_base_image
#   /!\/!\ -v option is equivalent to --volume, don't forget to replace by path where your project is. /!\/!\
#
#   ex:
#   Your project code is located at /home/app/php/GyverProject, then the command look like this:
#   docker run -ti -d -p 999:80 --name gyverproject -v /home/app/php/GyverProject:/home/app gyver_base_image
#
#   3). Build the project and start services :
#   docker exec -ti <Container ID> bash ./entrypoint.sh
#
# ON EVERY REBOOT
#   # Starting stopped container :
#   docker start <Container ID>
#
#   # Start services :
#   docker exec -ti <Container ID> bash ./gyver.sh
#

FROM rhyu/ubuntu:latest
MAINTAINER Gauvin Thibaut

# Base
RUN apt-get update && apt-get install -y \
  bash \
  nginx \
  python \
  php5-fpm \
  php5-cli \
  php5-mysql \
  php5-json \
  php5-intl \
  php5-curl \
  dialog \
  net-tools

# Install Mysql Server
RUN apt-get install -y \
  mysql-server

# Install NodeJs
RUN curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -
RUN apt-get install -y nodejs

# Configure Nginx
ADD app/config/docker/default /etc/nginx/sites-available/default
RUN chown -R www-data:www-data /var/lib/nginx

# Configure PHP
RUN cd /etc/php5/cli && \
  mv php.ini php.ini.backup && \
  ln -s ../fpm/php.ini
ADD app/config/docker/php.ini /etc/php5/fpm/php.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN chmod +x composer.phar
RUN mv composer.phar /usr/local/bin/composer

# Add Provisionning Scripts
ADD app/config/docker/entrypoint.sh /entrypoint.sh
ADD app/config/docker/gyver.sh /gyver.sh
RUN chmod +x /entrypoint.sh /gyver.sh

# Expose Port
EXPOSE 80

# Project Code
VOLUME ["/home/app"]
