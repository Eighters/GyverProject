# How to update your project :

If you want to update your project version to master or any other branches, follow those steps.    
Before we begin, make sure you have already a working version that you are able to work with.
If not, follow the installation tutorial :  
[Manual Provisioning](manual.md)  
[Docker Provisioning (Easiest)](docker.md)  

* **Pull the sources :**  
    Use `fetch` git commands to update your local sources with the remote git repository    
        
        $ git fetch origin --prune
    
    Switch to the branch you want to pull, for example "_master_"     
    
        $ git checkout master
    
    Then pull the sources from that branch    
        
        $ git pull origin master

* **Update Php Vendor & Application parameter.yml:**  
    **/!\ It's not mandatory but you also can update your composer version before install new library. You can deal like this:**
        
        # Update composer
        # Note that command requires administrator privileges
        $ sudo composer self-update
        
        # Install php dependencies
        $ composer install --no-interaction
    This will download latest php library & update the parameter.yml file, get the default values, you can update this later.

* **Update database :**  
    If you don't have the latest Doctrine Migrations  
    
        $ php app/console d:m:m  
    
    Then, you need to reload the fixtures to the database  
    
        $ php app/console d:f:l
  
* **Update frontEnd libs & Recompile static files with gulp :**  
        
        $ npm start
