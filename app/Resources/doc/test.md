# PHPUnit & Testing Documentation :

Get started about writing test in php with PHPUnit Framework.

**PHPUnit [Official Doc](http://phpunit.de/manual/current/en/writing-tests-for-phpunit.html)**

## Setup with Docker env

* **For Docker User only, you need start & connect to container :**
        
        # create & start container
        $ docker-compose up -d
        
        # Start bash termnial
        $ docker-compose run symfony bash
        
    Following commands must be run from devops user in docker container.
        
        # copy phpunit config
        $ cp phpunit.xml.dist phpunit.xml
        
        # Refresh Test DB
        $ dbrazTest
    
    This will drop test database if exist, create new one, create Tables & Load Fixtures  

### ---------------------------------------------------

### Setup with Local env (you prefer manual installation of project dependencies)

* **Check if you have PHPUnit installed :**  
        
        $ bin/phpunit --version
        
        # It should return :  
        $ PHPUnit 4.8.27 by Sebastian Bergmann and contributors.

* **Create phpunit.xml files :**  

        $ cp phpunit.xml.dist phpunit.xml
    
* **Create test database :**  

        $ php app/console doctrine:database:create --env=test

* **Create tables schema :**

        $ php app/console doctrine:schema:create --env=test
    
* **Load DataFixtures :**  
    
        $ php app/console doctrine:fixtures:load --env=test -n


## Launch PhpUnit tests :

* **Launch all the test suite :**  
        
        $ bin/phpunit -c app/phpunit.xml
    
* **Launch one particular Test :**  
        
        # base
        $ bin/phpunit -c app/phpunit.xml <path to your test file>
          
        # example  
        $ bin/phpunit -c app/phpunit.xml src/GyverBundle/Tests/Controller/DefaultControllerTest.php  

* **Launch one particular method of given test:**
        
        # base
        $ bin/phpunit -c app/phpunit.xml --filter <method name> <path to your file>
        
        # example
        $ bin/phpunit -c app/phpunit.xml --filter testIndex src/GyverBundle/Tests/Controller/DefaultControllerTest.php  
