# GET STARTED WITH DOCKER :

**Docker provisioning is Ready to work, follow this guide and RTFDM (read the fucking docker manual)**

More Infos :
[Docker Documentation](https://docs.docker.com/)

**-----------------------------------------------------**

## Prerequisites

Install [Docker](https://www.docker.com/) on your system.

- [Install instructions](https://docs.docker.com/installation/mac/) for Mac OS X
- [Install instructions](https://docs.docker.com/installation/ubuntulinux/) for Ubuntu
- [Install instructions](https://docs.docker.com/engine/installation/windows/) for Windows (prefer Docker for Windows than deprecated Docker Toolbox)

Install [Docker Compose](http://docs.docker.com/compose/) on your system.

- [Install instructions](https://docs.docker.com/installation/) for all supported systems

Check that you can use docker commands without sudo !
- To run docker command without sudo, you need to add your user (who has root privilages) to docker group & restart your sessions.
      
        $ sudo usermod -aG docker <user_name>

**-----------------------------------------------------**

## Installation:

* **Copying compose file :**   

  Create copy of `.env.example` and call it `.env` or just simply run this command on unix system:
  
        # Assume you are in project root
        $ cp .env.example .env
        
  Modify it to you own needs !

* **Create Images and Containers :**

    Run following command :
    
        $ docker-compose up -d
        
    You can go make a coffee !

* **Connect to app container and start provisionning Script :**  
    
        $ docker-compose run symfony bash
        $ cd /
        $ ./entrypoint.sh
        
    Go make another coffee !
    
    Note:  
    This scripts need to be executed only the first time you install the project.

**Your done !**

You can now access to following services on your host machine:

- **[Application](http://gyverproject.dev/)**
- **[MailCatcher](http://localhost:1080)**
- **[PhpMyAdmin](http://localhost:8080)**

**When you reboot your computer :**  
- Just simply run following command :

        $ docker-compose up -d

**-----------------------------------------------------**
        
## Docker-compose commands

* **See what is currently running**
    
        $ docker-compose ps
    
* **Start Containers**
    
        $ docker-compose start
    
* **Stop Containers**
    
        $ docker-compose stop
    
* **Remove Containers**
    
        $ docker-compose rm
    
* **Get logs**
    
        $ docker-compose logs -f

#### RUN command usage: 
    
    # Usage
    $ docker-compose run service command
        
    # Example
    $ docker-compose run symfony bash
        
**_Service are service name defined in the docker-compose file_**  
