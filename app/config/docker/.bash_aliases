# File lists
alias la='ls -a'  # List all
alias ll='ls -l'  # List detailed
alias lla='ll -a' # List all detailed

# Ask confirmation when removing or overwriting files
alias rm='rm -i'
alias cp='cp -i'
alias mv='mv -i'

# Symfony
alias symfony='php app/console'
alias sf='symfony'
alias sfixt='sf d:s:drop --env=test --force && sf d:s:create --env=test && sf d:f:load --env=test -n'

# :mode=shellscript:
