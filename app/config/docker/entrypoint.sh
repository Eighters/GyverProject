#!/usr/bin/env bash

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

echo "Install Composer Dependencies"
/bin/bash -l -c "cd /home/docker && composer install --no-interaction --prefer-dist --optimize-autoloader"

echo ''
echo '---------------------------------------'
echo ''

echo "Install NodeJs packages"
/bin/bash -l -c "cd /home/docker && npm install"

echo ''
echo '---------------------------------------'
echo ''

echo "Install Bower Globally"
/bin/bash -l -c "cd /home/docker && sudo npm install -g bower"

echo ''
echo '---------------------------------------'
echo ''

echo "Download Bower dependencies"
/bin/bash -l -c "cd /home/docker && bower install"

echo ''
echo '---------------------------------------'
echo ''

echo "Compile Assets"
/bin/bash -l -c "cd /home/docker && npm run build"

echo ''
echo '---------------------------------------'
echo ''

echo "Create Tables"
/bin/bash -l -c "cd /home/docker && php app/console doctrine:migrations:migrate -n"

echo ''
echo '---------------------------------------'
echo ''

echo "Load Development Fixtures"
/bin/bash -l -c "cd /home/docker && php app/console doctrine:fixtures:load -n"

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
