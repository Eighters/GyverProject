# Manual-Provisioning:

This commands was tested on Ubuntu 14.04 LTS and also work on other linux system 

## I) Build your environment:

**This command need to be executed only one time. After, build the project is very quick.**

* **Install Git:**  
    `sudo apt-get install git`
    
    Check if you have git installed on your machine:  
    ```bash
    git --version  
    git version 1.9.1
    ```

* **Install HTTP server, NGINX:**
    `sudo apt-get install nginx -y`
    
    Then, setup server config:  
    ```bash
    cd /etc/nginx/sites-available
    cp default default.backup
    sudo nano default
    ```

    ```
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
    
        error_log /var/log/nginx/GyverProject_error.log;
        access_log /var/log/nginx/GyverProject_access.log;
    }
    ```
    
    Save & quit. Then restart nginx service:  
    `sudo service nginx restart`
    
* **Install HTTP server, Apache 2:**
    * To install an Apache 2 server on your machine, you can follow this tutorial, very well written and tested by myself : [Installer un serveur apache2] (http://www.petit-laboratoire-de-graphisme-potentiel.com/tutoriels/installer-serveur-developpement-apache2-php5.html)

* **Install MySql client & server:**  
    `sudo apt-get install mysql-server mysql-client -y`
    
    During the installation process, a password will be required for root user, don't loose it !

* **Install Php5 libraries:**
    `sudo apt-get install php5-fpm php5-cli php5-mysql php5-intl php5-curl -y`

* **Configure PHP:**  
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
    ```
    
    Set the date timezone:  
    ```ini
    ;date.timezone =
    date.timezone = "Europe/Paris"
    ```

* **Install Ruby language:**  
    `sudo apt-get install ruby`
    
    Check if ruby is installed  
    `ruby -v`  
    `ruby 2.2.1p85 (2015-02-26 revision 49769) [x86_64-linux]`

* **Install RVM (Ruby Version Manager):**  
    ```bash
    # Import key
    gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3
    
    # Install RVM with ruby
    \curl -sSL https://get.rvm.io | bash -s stable --ruby
    ```
    
    Check if rvm is installed:  
    ```bash
    rvm -v
    rvm 1.26.11 (latest)
    ```

* **Intall & Use ruby v2.2.1 with RVM:**  
    ```bash
    # Install
    rvm install 2.2.1
    
    # Use
    rvm use 2.2.1
    ```

* **Install NodeJs:**
    ```bash
    sudo apt-get install python-software-properties python g++ make
    sudo add-apt-repository ppa:chris-lea/node.js
    sudo apt-get update
    sudo apt-get install nodejs
    ```
    
    Check Nodejs Version
    ```bash
    node -v
    v0.10.37
    ```

* **Install Bower for all project:**
    ```bash
    sudo npm install -g bower
    ```
    
    Check bower Version
    ```bash
    bower -v
    1.6.3
    ```
    
## II) Build the GyverProject baby yeah:

* **Clone the Repository:**  
    ```bash
    git clone git@github.com:TechGameCrew/GyverProject.git         --> use ssh protocol (need to generate SSH Key)
    git clone https://github.com/TechGameCrew/GyverProject.git     --> use https protocol
    ```

* **Cd to project directory:**  
    `cd GyverProject`

* **Download Composer.phar package:**  
    /!\ You need CURL to be able to run this command /!\  
    ```bash
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    ```
    
* **Install PHP vendors library (Symfony Core, Doctrine ORM, SwiftMailer ...):**  
    `composer install`   
     
* **Install Bundler into your project directory:**  
    `gem install bundler`
    
* **Install Ruby dependency (Capifony, Compass ...):**  
    `bundle install`
    
* **Install Bower dependency (Foundation, FontAwesome ...):**  
    `bower install`

* **Compile Css files:**
    `compass compile`
 
* **Give Read, Write and Execute privilege to Cache & log directory**
    ```bash
    sudo chmod 777 -R app/cache/
    sudo chmod 777 -R app/logs/
    ```

* **Go to localhost, if you have all done correctly you will see home page directory:**
