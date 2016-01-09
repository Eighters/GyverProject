#!/usr/bin/env bash

main() {

	# Use colors, but only if connected to a terminal, and that terminal
	# supports them.
	if which tput >/dev/null 2>&1; then
	  ncolors=$(tput colors)
	fi
	if [ -t 1 ] && [ -n "$ncolors" ] && [ "$ncolors" -ge 8 ]; then
	RED="$(tput setaf 1)"
	GREEN="$(tput setaf 2)"
	YELLOW="$(tput setaf 3)"
	BLUE="$(tput setaf 4)"
	BOLD="$(tput bold)"
NORMAL="$(tput  sgr0)"
	else
	RED=""
	GREEN=""
	YELLOW=""
	BLUE=""
	BOLD=""
	NORMAL=""
	fi

    echo "Start Nginx"
    nginx
    echo "Nginx server started"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Start Php5-fpm"
    php5-fpm
    echo "Php5-fpm is running"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Start MySql"
    service mysql start
    echo "MySql Server is running"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Install Composer Dependency"
    /bin/bash -l -c "cd /home/app && composer install"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Fix Bower issue with G4 fucking proxy"
    /bin/bash -l -c "git config --global url.'https://'.insteadOf git://"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Install NodeJs packages"
    /bin/bash -l -c "cd /home/app && npm install"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Install Bower dependency"
    /bin/bash -l -c "cd /home/app && ./node_modules/bower/bin/bower install --allow-root -y --config.interactive=false"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Compile Assets"
    /bin/bash -l -c "cd /home/app && ./node_modules/gulp/bin/gulp.js build"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Create Database"
    /bin/bash -l -c "cd /home/app && php app/console doctrine:database:create"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Create Table"
    /bin/bash -l -c "cd /home/app && php app/console doctrine:migrations:migrate -n"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Load Development Fixtures"
    /bin/bash -l -c "cd /home/app && php app/console doctrine:fixtures:load -n"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Watch JavaScript & Sass directory"
    /bin/bash -l -c "cd /home/app && ./node_modules/gulp/bin/gulp.js watch"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Chmod Logs & Cache Directory"
    /bin/bash -l -c "cd /home/app && chmod 777 -R app/cache"
    /bin/bash -l -c "cd /home/app && chmod 777 -R app/logs"

    echo ''
    echo '---------------------------------------'
    echo ''

    printf "${BOLD}"
    echo '                                                                                 __         '
    echo '                                                               __               /\ \__      '
    echo '   __    __  __  __  __    __   _ __       _____   _ __   ___ /\_\     __    ___\ \  _\     '
    echo ' / _  \ /\ \/\ \/\ \/\ \ / __ \/\  __\    /\  __ \/\  __\/ __ \/\ \  / __ \ / ___\ \ \      '
    echo '/\ \_\ \\ \ \_\ \ \ \_/ /\  __/\ \ \/     \ \ \_\ \ \ \//\ \_\ \ \ \/\  __//\ \__/\ \ \     '
    echo '\ \____ \\ \____ \ \___/\ \____\\ \_\      \ \ ,__/\ \_\\ \____/\ \ \ \____\ \____\\ \ \___ '
    echo ' \/___ \ \\/___/  \/__/  \/____/ \/_/       \ \ \/  \/_/ \/___/\ \_\ \/____/\/____/ \\____/ '
    echo '   /\____/   /\___/                          \ \_\            \ \____/                      '
    echo '   \_/__/    \/__/                            \/_/             \/___/                       '
    echo ''
    echo ''
    printf "${YELLOW}"
    echo "Success, Your are ready to develop ! :D"
    printf "${NORMAL}"
    echo ''

}

main

