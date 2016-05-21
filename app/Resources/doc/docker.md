# GET STARTED WITH DOCKER :

**Docker provisioning is Ready to work, follow this guide and RTFDM (read the fucking docker manual)**

More Infos :
[Docker Documentation](https://docs.docker.com/)

##  Install Docker
*   **Windaube & MAC OSX :**  
    **Docker is no longer available for Windaube OS, you can try to use a REAL OS FOR REAL DEVELOPER**
    **Need to update documentation for MAC OSX user.**

*   **Linux :**
    * **Simply run this command :**  
        ```bash
        sudo apt-get update
        sudo apt-get install docker.io
        ```
        
    * **Check if Docker is installed :**  
        ```bash
        sudo docker -v
        Docker version 1.6.2, build 7c8fca2
        ```
        
    * **Docker without sudo**  
        To run docker command without sudo, you need to add your user (who has root privileges) to docker group  
        ```bash
        sudo usermod -aG docker <user_name>
        ```
        
## DOCKER Basic Commands:  

* **List images :**  
    ```bash
    docker images
    ```
 
    ```bash
    thibaut@thibaut-UX32VD:/home/app/docker/GyverProject (master)$  docker images
    REPOSITORY          TAG                 IMAGE ID            CREATED             VIRTUAL SIZE
    app                 latest              5a8e4fe6db5c        7 hours ago         759.7 MB
    rhyu/ubuntu         latest              9a046d88aafb        9 days ago          409.5 MB
    ```
  
* **List Current Running Container :**  
    ```bash
    docker ps
    ```
 
 Note if no container is started, this command return blank results.
 
* **List all Container :**  
    ```bash
    docker ps
    ```

* **List running Container :**  
    ```bash
    docker ps -a
    ```

* **3° Connect to running docker container :**  
    ```bash
    # list running container
    docker ps
    # Connect to it
    docker exec -ti <CONTAINER ID> bash
    ```

* **Delete Images :**  
    ```bash
    docker rmi <IMAGE ID>
    ```
 
 Note: You can't delete image used by active container.
 
* **Delete Container**  
    ```bash
    docker rm <CONTAINER ID>
    ```
 
 Note: You can't delete running containers, stop it before !
 
* **Stop Container**  
    ```bash
    docker stop <CONTAINER ID>
    ```

* **Start Container**  
    ```bash
    docker start <CONTAINER ID>
    ```
  
  Note: You need to create container before starting it !


## Build GyverProject Images & Starting DEV container :  

Once you have docker properly installed you can build your own Project images and run it inside container for development  

* **Before, you need to git clone clone the GyverProject repository & cd to the project.**  
    Use one this two commands, depending on what protocol you want to use.  
    
    ```bash
    # Cloning repository
    git clone https://github.com/TechGameCrew/GyverProject.git     --> use https protocol (Easy Way)
    git clone git@github.com:TechGameCrew/GyverProject.git         --> use ssh protocol (need to generate & configure SSH Key before)
    
    # Cd to repository
    cd GyverProject
    ```
    
* **1° Create GyverProject base image for your container:**  
    ```bash
    docker build -t <Image Name> .
    ```
  
* **2° Start Container from newly created docker image:**  
    ```bash
    docker run -ti -d -p 999:80 --name gyverproject -v /path/to/code/local:/home/app <Image Name>
    ```
 
    Run command option :
    * **-ti**: run container in interactive mode  
    * **-d**: run container in daemon mode (persist in background)  
    * **-p**: bind port (-p port-local:port-docker)  
    * **--name**: give a name to your container  
    * **-v**: mount shared directory inside container (-v local/path:docker/path)  
    * **Image Name**: can be just image name like 'app' or image name & tag like 'app:latest'   
    The image name can be set when you build your image with  
    `docker build -t <Image Name> .`  
 
* **3° Build Project inside docker container :**  
    ```bash
    # list running container
    docker ps
    # Connect to it
    docker exec -ti <CONTAINER ID> ./entrypoint.sh
    ```

* **Your done [http://localhost:999](http://localhost:999) !**


### Once your have successfully build the project one time, when you restart your computer, you just need to :
 
* **Start container :**  
    ```bash
    docker start <CONTAINER ID>
    ```

* **Run starting script :**  
    ```bash
    docker exec -ti <CONTAINER ID> bash -l ./gyver.sh
    ```
