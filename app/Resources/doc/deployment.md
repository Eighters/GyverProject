# Deployment

The deployment of the application is done with capifony: http://capifony.org


## Requirements

- Ruby must be installed on your local machine.

- Dependencies (Nginx, Mysql, Php etc ...) must be installed and configured on the remote server.


### Install Ruby dependencies with bundler:

    $ gem install bundler
    $ bundle install

You can check that capifony is correctly installed by running the following
command in the project directory:

    $ cap -T

### In `app/config`, copy the `deploy.rb.example` to `deploy.rb`

### Set the values required.

After settings correctly the server user, address etc... You need to init the remote server directory structure required by Capifony  
Run this command on your local machine

    $ cap deploy:setup
     
Capifony will try to ssh to the remote server, and create required directories

### Setup Nginx config:  

The remote server need a specific Nginx config, 
replace content of `/etc/nginx/sites-available/default` by:

    server {
        listen 80;
        
        # Replace by content of deploy_to: in deploy.rb
        root <deploy_to:>/current/web;
        
    
        location / {
            try_files $uri @rewriteapp;
        }
        
    
        location @rewriteapp {
            rewrite ^(.*)$ /app.php/$1 last;
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

Don't forget to restart Nginx service to apply change !

    $ sudo service nginx restart

### -----------------------


## Deployment

- To deploy code, simply run

        $ cap deploy
    
    This will deploy default "master" branch on remote machine.

- To deploy custom branch, run

        $ cap -S deploy_branch=MyBranch deploy
        
    Where `MyBranch` is the branch you want to deploy on remote machine
    
Your done with Capifony, enjoy efficient application deployment workflow !
