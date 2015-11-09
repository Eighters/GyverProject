#!/bin/sh


echo "Start Nginx server"
nginx
echo "Nginx server started"


echo "Start Php5-fpm process"
php5-fpm
echo "Php5-fpm is running"


echo "Launch MailCatcher server"
/bin/bash -l -c "cd /home/app && mailcatcher"


echo "Chmod log & cache directory"
/bin/bash -l -c "cd /home/app && chmod 777 -R app/cache"
/bin/bash -l -c "cd /home/app && chmod 777 -R app/logs"


echo "Start compass watching directory process"
/bin/bash -l -c "cd /home/app && compass watch"
