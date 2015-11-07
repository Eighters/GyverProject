USAGE:
 # Build GyverProject image :
 docker build -t app .
 
 # List images:
 docker images
 
 # Run container in daemon mode & Open port 999 & Mount shared directory :
 docker run -ti -d -p 999:80 --name gyverproject -v /path/to/code/local:/home/app app bash -l
 
 # List Current Running Container :
 docker ps
 
 # List All Container :
 docker ps -a
 
 # Connect to running container :
 docker exec -ti <hashContainerID> bash -l
 
 # Build the project :
 composer install
 bundle install
 bower install --allow-root
 mailcatcher
 compass compile
 
 # Start Nginx & Php5 Process :
 nginx
 php5-fpm
 
 # Exit Container :
 exit
 
 # Add right permission to repository :
 sudo chmod 777 -R app/cache
 sudo chmod 777 -R app/log
 sudo chown 'youruser':'yourusergroup' /path/to/your/project
 
 # Start developing :D
