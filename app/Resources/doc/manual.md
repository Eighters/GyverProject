# Manual-Provisioning:

This commands was tested on Ubuntu 14.04 LTS and also work on other linux system like Debian or Linux Mint

This will help to setup your local environement. After you need to build & run the project here: [Build & Run](install.md)

## Build your local environment:

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
    
Now setup is complete and you are able to run the Gyver Project properly, you can now follow this guide to install it.
 * [Build & Run](install.md)
