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
	NORMAL="$(tput sgr0)"
	else
	RED=""
	GREEN=""
	YELLOW=""
	BLUE=""
	BOLD=""
	NORMAL=""
	fi

    echo "Start Nginx server"
    nginx
    echo "Nginx server started"

    echo ''
    echo '---------------------------------------'
    echo ''

    echo "Start Php5-fpm process"
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

    echo "Chmod log & cache directory"
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
    echo "Success, Your are ready to develop"
    printf "${NORMAL}"

}

main
