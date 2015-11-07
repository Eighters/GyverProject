USAGE:
 # Build GyverProject image :
 docker build -t app .

 # List images:
 docker images
 
 # Run container in daemon mode & Open port 999 & Mount shared directory :
 docker run -ti -d -p 999:80 -p 1080:1080 --name gyverproject -v /path/to/code/local:/home/app app bash -l

 # List Current Running Container:
 docker ps
 
 # List All Container:
  docker ps -a
 
 # Connect to running container :
 docker exec -ti <hashContainerID> bash -l
 
 # Build the project:
 composer install
 bundle install
 bower install --allow-root
 mailcatcher
 compass compile
 chmod 777 -R app/cache
 chmod 777 -R app/log
 
 # Exit container
 exit
 
 # Launch Nginx & Php5-fpm services to running container :
 docker exec -ti <hashContainerID> /entrypoint.sh
 
 # Start developing :D
