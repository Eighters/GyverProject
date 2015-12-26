# Manual-Provisioning:

This commands was tested on Ubuntu 14.04 LTS and also work on other linux system 

## I) Build your environment:

**This command will setup your environment to the requirment of the GyverProject & need to be executed only one time.**  
**After this, build the project is very quick.**

* **Install Git :**  
    `sudo apt-get install git`
    
    Check if you have git installed on your machine:  
    ```bash
    git --version  
    git version 1.9.1
    ```

* **Install utilities tools :**  
    ```bash
    sudp apt-get install htop multitail curl
    ```
    
    **Htop:** interactive tools that display process running on your machine  
    **Multitail:** view multiple logfiles windowed on console  
    **Curl:** providing a library and command-line tool for transferring data using various protocols  

----

**Install HTTP server. Chose Between Apache2 or Nginx.**  
/!\ Don't install both of them /!\

**Note :**  
If you install Nginx, you need to install php5-fpm them.

* **NGINX :**  
    `sudo apt-get install nginx -y`
    
    Then, setup server config:  
    ```bash
    cd /etc/nginx/sites-available
    cp default default.backup
    sudo nano default
    ```

    ```bash
    server {
        listen 80;
        # path to your project
        root /home/app/php/GyverProject/web;       
        location / {
            try_files $uri @rewriteapp;
        }
        location @rewriteapp {
            rewrite ^(.*)$ /app_dev.php/$1 last;
        }
        location ~ ^/(app|app_dev|config)\.php(/|$) {
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param HTTPS off;
        }
        # Log files
        error_log /var/log/nginx/GyverProject_error.log;
        access_log /var/log/nginx/GyverProject_access.log;
    }
    ```
    
    Save & quit. Then, restart nginx service to apply change :  
    `sudo service nginx restart`
    
    **Note:** everytime you change server config, you need to restart nginx service.
    
* **Install Php5-fpm :**  
    `sudo apt-get install php5-fpm php5-cli php5-mysql php5-intl php5-curl -y`
    
* **Configure Php5-fpm :**  
    ```bash
    # Go to php cli directory
    cd /etc/php5/clI
    # Make a backup of php.ini file
    sudo mv php.ini php.ini.backup 
    # Create a symlink to fpm php.ini
    sudo ln -s ../fpm/php.ini
    # Edit fpm php.ini
    cd ../fpm  
    sudo nano php.ini
    # And set the date timezone
    ;date.timezone =
    date.timezone = "Europe/Paris"
    ```
        
    Restart Php5-fpm service:  
    `sudo service php5-fpm restart`
    
----

* **Apache 2 :**  
    To install an Apache 2 server on your machine, you can follow this [tutorial](http://www.petit-laboratoire-de-graphisme-potentiel.com/tutoriels/installer-serveur-developpement-apache2-php5.html), very well written and tested by Robin Billy (ask him if you have more question). 
    /!\ Don't forget to set your date.timezone in your php.ini files. /!\
    
----

* **Install MySql client & server :**  
    `sudo apt-get install mysql-server mysql-client -y`
    
    During the installation process, a password will be required for root user, **Don't loose it !**

* **Install Ruby language :**  
    `sudo apt-get install ruby`
    
    Check if ruby is installed  
    `ruby -v`  
    `ruby 1.9.3`

* **Install RVM (Ruby Version Manager) :**  
    /!\ You need CURL to be able to run this command /!\

    ```bash
    # Import key
    curl -sSL https://rvm.io/mpapis.asc | gpg --import -
    # Install RVM with ruby
    \curl -sSL https://get.rvm.io | bash -s stable --ruby
    ```
    
    Check if rvm is installed:  
    ```bash
    rvm -v
    rvm 1.26.11 (latest)
    ```
    
    **Note:** to use rvm features, you need to be in interactive shell.  
    Use this command to switch in interactive mode:  
    `bash -l`
    If you reboot your computer, you need to run this again. To start every new shell in interactive mode, please refer to [stackoverflow](http://stackoverflow.com/questions/5352827/why-doesnt-rvm-work-in-a-bash-script-like-it-works-in-an-interactive-shell)

* **Intall & Use ruby v2.2.1 with RVM :**  
    ```bash
    # Install
    rvm install 2.2.1
    # Use
    rvm use 2.2.1
    ```
    
* **Install Bundler :**  
    `gem install bundler`
    
    Check Bundler Version
    ```bash
    bundler -v
    Bundler version 1.10.6
    ```

* **Install NodeJs :**
    Node.js is available from the NodeSource Debian and Ubuntu binary distributions repository  
    /!\ You need CURL to be able to run this command /!\  
    ```bash
    curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -
    sudo apt-get install -y nodejs
    ```
    
    Check Nodejs Version
    ```bash
    node -v
    v4.2.3
    ```

* **Install Composer :**  
    /!\ You need CURL to be able to run this command /!\  
    ```bash
    # Download binaries
    curl -sS https://getcomposer.org/installer | php
    # Move it into user bin folder
    sudo mv composer.phar /usr/local/bin/composer
    # Manage access right
    sudo chmod +x /usr/local/bin/composer
    ```
    
    Check Composer Version  
    ```bash
    composer --version
    Composer version 1.0-dev (58a6d4b7d305a0ff98e8417a51b59b7d2cfa638c) 2015-11-10 16:35:29
    ```
    
    **Note:** don't miss to frequently update your composer version with this command:  
    `composer self-update`
    
## II) Build the GyverProject baby yeah :  

* **Clone the Repository :**  
    Use one this two commands, depending on what protocol you want to use.  
    ```bash
    git clone https://github.com/TechGameCrew/GyverProject.git     --> use https protocol (Easy Way)
    git clone git@github.com:TechGameCrew/GyverProject.git         --> use ssh protocol (need to generate & configure SSH Key before)
    ```

* **Cd to project directory :**  
    `cd GyverProject`

* **Install Ruby dependencies (Mailcatcher & Capifony):**  
    `bundle install`
    
* **Install NodeJs dependencies (Bower, Gulp & Gulp Plugins) :**  
    `npm install`
    
* **Install PHP (BackEnd) dependencies (Symfony Core, Doctrine ORM, SwiftMailer, Twig ...) :**  
    `composer install`
    
    **Note:** You will be asking during this process to give some parameter to application. Don't worry about this and press enter, you can configure it later with your code editor in app/config/parameter.yml
    
* **Install Bower (FrontEnd) dependencies (Materialize, FontAwesome, SeweetAlert ...) :**  
    `./node_modules/bower/bin/bower install`
    
* **Compile Sass & Js files :**  
    `./node_modules/gulp/bin/gulp.js build`
    
* **Give Read, Write and Execute privilege to Cache & log directory :**  
    ```bash
    sudo chmod 777 -R app/cache/ app/logs/
    ```
    
* **Go to [localhost](http://localhost/), if you have all done correctly you will see home page  :D :D :D \O/**  


* **In Developement Environement, you may use following command to watch any change on Sass And Js file and recompile them :**  
    `./node_modules/gulp/bin/gulp.js watch`
