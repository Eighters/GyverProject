# Manual-Provisioning:

This commands was tested on Ubuntu 14.04 LTS and also work on other linux system 

## I) Clone The repository:
* Check if you have git installed on your machine:
    ```
    git --version
    git version 1.9.1
    ```

* Install Git:
    ```
    sudo apt-get install git
    ```

* Git clone the repository:
    ```
    git clone git@github.com:TechGameCrew/GyverProject.git         --> use ssh protocol (need to generate SSH key)
    git clone https://github.com/TechGameCrew/GyverProject.git     --> use https protocol
    ```

* Cd to the directory:
    ```
    cd /GyverProject
    ```

## 2) Install Web Server, php, and MySql Packages:
* [Follow the guide](http://www.lonelycoder.be/nginx-php-fpm-mysql-phpmyadmin-on-ubuntu-12-04/)

## 3) Set your php.ini files
* [Follow the guide](http://www.lonelycoder.be/nginx-php-fpm-mysql-phpmyadmin-on-ubuntu-12-04/)

## 4) Install Symfony Libraries
```
php composer.phar install
```

## 5) Install Gyver Project Libraries

* Install Ruby
    ```
    sudo apt-get install ruby
    ```
    
* Install RVM (Ruby Version Manager)
    ```
    gpg --keyserver hkp://keys.gnupg.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3
    \curl -sSL https://get.rvm.io | bash -s stable --ruby
    ```

* Install & use ruby 2.2.1 version with RVM:
    ```
    $ rvm install 2.2.1
    $ rvm use 2.2.1
    ```

* Check Ruby version used:
    ```
    ruby -v 
    ruby 2.2.1p85 (2015-02-26 revision 49769) [x86_64-linux]
    ```

* Install Bundler:
    ```
    gem install bundler
    ```

* Install Ruby Project Dependency:
    ```
    bundler install
    ```

* [Install Nodejs and Npm](https://nodejs.org/en/download/)

* Check node and npm version:
    ```
    node -v
    v0.12.7
    ```
    ```
    npm -v
    2.13.1
    ```

* Install Bower:              
    ```
    npm install -g bower
    ```
    
    > This will install bower for all project in your computer (-g flag) 
    > (Bower requires node, npm and git) 
    
* Install Bower Dependency:              
    ```
    bower install
    ```

* It's Done you can start coding ! :D

* You need to run this command every time you modify .scss files:    
    ```
    php app/console cypress:compass:compile
    ```

* In case you want to say where compass bin is located:
    ```
    which compass
    /home/thibaut/.rvm/gems/ruby-2.2.1/bin/compass
    ```
