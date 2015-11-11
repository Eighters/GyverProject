# PHPUnit & Testing Documentation :

Get started about writing test in php with PHPUnit Framework.

**PHPUnit [Official Doc](http://phpunit.de/manual/current/en/writing-tests-for-phpunit.html)**

## Setup :
    
* **Check if you have PHPUnit installed :**  
    `bin/phpunit --version`  
    
    It should return :  
    `PHPUnit 4.8.15 by Sebastian Bergmann and contributors.`

* **Create phpunit.xml files :**  
    `cp phpunit.xml.dist phpunit.xml`
    
* **Create test database :**  
    `php app/console doctrine:database:create --env=test`

* **Create tables schema :**
    `php app/console doctrine:schema:create --env=test`
    
* **Load DataFixtures :**  
    `php app/console doctrine:fixtures:load --env=test -n`
    
    **Note :** If you need to reload your fixtures, drop the database & restart preceding steps.
    `php app/console doctrine:schema:drop --env=test --force`

For more convenience, i have create an alias command to drop schema, create it, and load fixtures.  
Copy `app/config/docker/.bash_aliases` files into your user home directory like `/home/user/.bash_aliases`.  
To use it :  `sfixt`

## Launch PhpUnit tests :

* **Launch all the test suite :**  
    `bin/phpunit -c app/phpunit.xml`
    
* **Launch one particular test :**  
    `bin/phpunit -c app/phpunit.xml <path to your test file>`  
    `bin/phpunit -c app/phpunit.xml src/GyverBundle/Tests/Controller/DefaultControllerTest.php`  

* **Launch one particular method of given test:**  
    `bin/phpunit -c app/phpunit.xml --filter <method name> <path to your file>`  
    `bin/phpunit -c app/phpunit.xml --filter testIndex src/GyverBundle/Tests/Controller/DefaultControllerTest.php`  
