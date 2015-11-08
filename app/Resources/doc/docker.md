# GET STARTED WITH DOCKER :

More infos :
[Docker Doc](https://docs.docker.com/)

## Install Docker :

* **Simply run this command :**  
    ```
    sudo apt-get update  
    sudo apt-get install docker.io
    ```
 
* **Check if Docker is installed :**  
   `sudo docker -v`  
   `Docker version 1.6.2, build 7c8fca2`

## Basic Commands:  

* **List images :**  
    `docker images`
 
 ex:
    ```
    thibaut@thibaut-UX32VD:/home/app/docker/GyverProject (master)$  docker images
    REPOSITORY          TAG                 IMAGE ID            CREATED             VIRTUAL SIZE
    app                 latest              5a8e4fe6db5c        7 hours ago         759.7 MB
    rhyu/ubuntu         latest              9a046d88aafb        9 days ago          409.5 MB
    ```
  
* **List Current Running Container :**  
    `docker ps`
 
 Note if no container is started, this command return blank results.
 
* **List all Container :**  
    `docker ps -a`
 
 ex:
    ```
    thibaut@thibaut-UX32VD:/home/app/docker/GyverProject (master)$ docker ps -a
    CONTAINER ID        IMAGE               COMMAND             CREATED             STATUS              PORTS                          NAMES
    7421597cd17d        app:latest          "/bin/bash"         7 hours ago         Up 12 minutes       999/tcp, 0.0.0.0:999->80/tcp   gyverproject    
    ```

* **Delete Images :**  
    `docker rmi <IMAGE ID>`
 
 Note: You can't delete image used by active container.
 
* **Delete Container**  
    `docker rm <CONTAINER ID>`
 
 Note: You can't delete running containers, stop it before !
 
* **Stop Container**  
     `docker stop <CONTAINER ID>`

* **Start Container**  
     `docker start <CONTAINER ID>`
  
  Note: You need to create container before starting it !

## Build GyverProject Images & Starting DEV container :  

Before, you need to git clone clone the GyverProject repository & cd to the project.

* **1° Build GyverProject image :**  
    `docker build -t <Container Name> .`
  
* **2° Run container :**  
    `docker run -ti -d -p 999:80 -p 1080:1080 --name gyverproject -v /path/to/code/local:/home/app <Image Name>`
 
 docker run option :
    * **-ti**: run container in interactive mode  
    * **-d**: run container in daemon mode  
    * **-p**: open port in container  
    * **--name**: give a name to container  
    * **-v**: mount shared directory inside container  
    * **Image Name**: can be just image name like 'app' or image name & tag like 'app:latest'   
    The image name can be set when you build your image with `docker build -t imageName .` 
 
* **3° Connect to running container :**  
    `docker exec -ti <CONTAINER ID> bash -l`

 You are now inside your docker container with root user.
 
* **4° Build the Project :**  
    ```
    composer install
    bundle install
    bower install --allow-root
    mailcatcher
    compass compile
    sudo chmod 777 -R app/cache
    sudo chmod 777 -R app/log
    ```
 
* **5° Start Nginx & Php5 Process :**  
    ```
    nginx
    php5-fpm
    ```
 
* **6° Exit Container :**  
    `exit`
 
* **7° Add right permission to repository :**  
    `sudo chown -R 'youruser':'yourusergroup' /path/to/your/project`
 
## Start developing :D

Once your have successfully build the project one time, when you restart your computer, you just need to :
 
* **Start container :**  
    `docker start <CONTAINER ID>`

* **Connect to running container & start Nginx & Php5-fpm process :**  
    `docker exec -ti <CONTAINER ID> bash -l`
    `nginx`
    `php5-fpm`
    `exit`
 
 Example :
    ```
    thibaut@thibaut-UX32VD:/home/app/php/GyverProject (master)$ docker ps -a
    CONTAINER ID        IMAGE               COMMAND             CREATED             STATUS                     PORTS               NAMES
    7421597cd17d        app:latest          "/bin/bash"         22 hours ago        Exited (0) 8 seconds ago                       gyverproject        
    thibaut@thibaut-UX32VD:/home/app/php/GyverProject (master)$ docker start 7421597cd17d 
    7421597cd17d9da7d5719ff920d2b6f1eaac775f35f6f77db5d609a34b6328e0
    thibaut@thibaut-UX32VD:/home/app/php/GyverProject (master)$ docker exec -ti 7421597cd17d bash -l
    root@7421597cd17d:/home/app# 
    root@7421597cd17d:/home/app# nginx
    root@7421597cd17d:/home/app# 
    root@7421597cd17d:/home/app# php5-fpm 
    root@7421597cd17d:/home/app# 
    root@7421597cd17d:/home/app# exit
    logout
    thibaut@thibaut-UX32VD:/home/app/php/GyverProject (master)$ 
    ```
 
* **Your done [here](http://localhost:999) !**
