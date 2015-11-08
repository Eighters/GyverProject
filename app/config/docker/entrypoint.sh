#!/bin/sh


echo "Start Nginx"
nginx
echo "Nginx server started"


echo "Start Php5-fpm"
php5-fpm
echo "Php5-fpm is running"


echo "Install Bundler"
/bin/bash -l -c "gem install bundler"

echo "Install composer dependency"
/bin/bash -l -c "cd /home/app && composer install"

echo "Install ruby dependency"
/bin/bash -l -c "cd /home/app && bundle install"

echo "Install bower dependency"
/bin/bash -l -c "cd /home/app && bower install --allow-root"

echo "Compile asset"
/bin/bash -l -c "cd /home/app && compass compile"

echo "Chmod log & cache Dir"
/bin/bash -l -c "cd /home/app && chmod 777 -R app/cache"
/bin/bash -l -c "cd /home/app && chmod 777 -R app/logs"

echo "Launch MailCatcher server"
/bin/bash -l -c "cd /home/app && mailcatcher"

echo "Success, Your are ready to develop"
