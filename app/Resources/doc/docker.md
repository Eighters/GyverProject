# GET STARTED WITH DOCKER :

**Docker provisioning is Ready to work, follow this guide and RTFDM (read the fucking docker manual)**

More Infos :
[Docker Documentation](https://docs.docker.com/)


## Prerequisites

Install [Docker](https://www.docker.com/) on your system.

* [Install instructions](https://docs.docker.com/installation/mac/) for Mac OS X
* [Install instructions](https://docs.docker.com/installation/ubuntulinux/) for Ubuntu Linux
* [Install instructions](https://docs.docker.com/installation/) for other platforms

Install [Docker Compose](http://docs.docker.com/compose/) on your system.

* [Install instructions](https://docs.docker.com/installation/) for all supported systems

## Installation:

* **Copying compose file:**   

  Create copy of 'docker-compose.yml.example' and call it 'docker-compose.yml' or just simply run this command on unix system:
  
    ```bash
   $ cp docker-compose.yml.example docker-compose.yml
    ```

* **Create Images and Containers:**

    Run following command:
    ```bash
    $ docker-compose up -d
    ```

* **Connect to app container and start provisionning Script :**  
    ```bash
   $ docker-compose run symfony bash
   $ cd /
   $ ./entrypoint.sh
    ```

* **Your done !**

* **When you reboot your computer:**  

    Just simply run following command:
    ```bash
    $ docker-compose up -d
    ```
