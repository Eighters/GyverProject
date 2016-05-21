# Manual-Provisioning:

This commands was tested on Ubuntu 14.04 LTS and also work on other linux system like Debian or Linux Mint
/!\ You need to to setup your local environement to be able to build & run the project
* [Manual Provisioning](manual.md)

## Install the Gyver Project :  

* **Clone the Repository :**  
    Use one this two commands, depending on what protocol you want to use.  
    ```bash
    git clone https://github.com/TechGameCrew/GyverProject.git     --> use https protocol (Easy Way)
    git clone git@github.com:TechGameCrew/GyverProject.git         --> use ssh protocol (need to generate & configure SSH Key before)
    ```

* **Cd to project directory :**  
    `cd GyverProject`
    
* **Install PHP (BackEnd) dependencies (Symfony Core, Doctrine ORM, SwiftMailer, Twig ...) :**  
    `composer install`
    
    **Note:** You will be asking during this process to give some parameter to application. Don't worry about this and press enter, you can configure it later with your code editor in app/config/parameter.yml
    
* **Install NodeJs dependencies (Bower, Gulp & Gulp Plugins) :**  
    `npm install`

* **Download FrontEnd Asset & start gulp default tasks:**  
    `npm start`
    
* **Give Read, Write and Execute privilege to Cache & log directory :**  
    ```bash
    sudo chmod 777 -R app/cache/ app/logs/
    ```
    
* **Go to [localhost](http://localhost/), if you have all done correctly you will see home page  :D :D :D \O/**  


* **During Development, you may use following command to watch any change on Sass, Html & Js files and recompile them & refresh server them :**  
    `npm run dev`

    **Note:** This will start a BrowserSync server connected to your app using proxy.  
    Once this running, you can connect any other browser using the external ip address given by the command prompt.  
    Any change detected on Html, Css or Javascript file will automatically refresh every synced browser.
