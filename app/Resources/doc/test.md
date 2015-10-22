# Test:

Get started about writing test in php with PHPUnit Framework

* [PHPUnit Doc](http://phpunit.de/manual/current/en/writing-tests-for-phpunit.html)

## Setup PhpUnit

* Create phpunit.xml files:  
    `cp phpunit.xml.dist phpunit.xml`
    
* Check if you have PHPUnit installed:  
    ` bin/phpunit --version`  
    
    It should return:  
    `PHPUnit 4.8.15 by Sebastian Bergmann and contributors.`
    
## Launch PhpUnit

* Lancer toute la suite de test:  
    `bin/phpunit -c app/phpunit.xml`
    
* Lancer un test en particulier:  
    `bin/phpunit -c app/phpunit.xml src/GyverBundle/Tests/Controller/DefaultControllerTest.php`  

     **La commande prend un argument supplémentaire: le chemin vers le test à éxécuter.**

* Lancer un test en particulier ET une méthode en particulière:  
    `bin/phpunit -c app/phpunit.xml --filter testIndex src/GyverBundle/Tests/Controller/DefaultControllerTest.php`
    
     **La commande prend un argument supplémentaire: --filter { method name }**

* Lancer les tests ET générer un rapport de code coverage:  
    `bin/phpunit -c app/phpunit.xml --coverage-html gyver-report`
    
     **La commande prend un argument supplémentaire: --coverage-html { path to generate report }**
