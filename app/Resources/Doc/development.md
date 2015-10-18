# Manual-Provisionning:

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
    git clone git@github.com:TechGameCrew/ProG4.git         --> use ssh protocol (need to generate SSH key)
    git clone https://github.com/TechGameCrew/ProG4.git     --> use https protocol
    ```

* Cd to the directory:
    ```
    cd /ProG4
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

* [Install Ruby](https://www.ruby-lang.org/fr/documentation/installation/)

* [Install RVM (Ruby Version Manager)](https://rvm.io/rvm/install)

* Use ruby 2.2.1 version with RVM:
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

* Install net-ssh Packages:
    ```
    gem install net-ssh -v '3.0.1'
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

* You need to run this command every time you modify .scss files:
    > You can start Developping FrontEnd Application using Sass and Foundation
    
    ```
    php app/console cypress:compass:compile
    ```

## Symfony 2 Documentation :

* [Basic Tutorial Symfony 2 (Made a blog with Symfony 2)](http://keiruaprod.fr/symblog-fr/)
* [Install Foundation with Sass](http://foundation.zurb.com/docs/sass.html)
* [Fixtures Documentation](http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html)
* [Migrations Documentation](http://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html)
* [Writing tests with PHPUnit](http://phpunit.de/manual/current/en/writing-tests-for-phpunit.html)
